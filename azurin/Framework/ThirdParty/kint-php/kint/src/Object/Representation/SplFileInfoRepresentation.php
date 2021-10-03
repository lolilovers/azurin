<?php

namespace Kint\Object\Representation;

use Kint\Utils;
use SplFileInfo;

class SplFileInfoRepresentation extends Representation
{
    public $perms;
    public $flags;
    public $path;
    public $realpath;
    public $linktarget;
    public $size;
    public $is_dir = false;
    public $is_file = false;
    public $is_link = false;
    public $owner;
    public $group;
    public $ctime;
    public $mtime;
    public $typename = 'Unknown file';
    public $typeflag = '-';
    public $hints = array('fspath');

    public function __construct(SplFileInfo $fileInfo)
    {
        parent::__construct('SplFileInfo');

        if ($fileInfo->getRealPath()) {
            $this->realpath = $fileInfo->getRealPath();
            $this->perms = $fileInfo->getPerms();
            $this->size = $fileInfo->getSize();
            $this->owner = $fileInfo->getOwner();
            $this->group = $fileInfo->getGroup();
            $this->ctime = $fileInfo->getCTime();
            $this->mtime = $fileInfo->getMTime();
        }

        $this->path = $fileInfo->getPathname();

        $this->is_dir = $fileInfo->isDir();
        $this->is_file = $fileInfo->isFile();
        $this->is_link = $fileInfo->isLink();

        if ($this->is_link) {
            $this->linktarget = $fileInfo->getLinkTarget();
        }

        switch ($this->perms & 0xF000) {
            case 0xC000:
                $this->typename = 'Socket';
                $this->typeflag = 's';
                break;
            case 0x6000:
                $this->typename = 'Block device';
                $this->typeflag = 'b';
                break;
            case 0x2000:
                $this->typename = 'Character device';
                $this->typeflag = 'c';
                break;
            case 0x1000:
                $this->typename = 'Named pipe';
                $this->typeflag = 'p';
                break;
            default:
                if ($this->is_file) {
                    if ($this->is_link) {
                        $this->typename = 'File symlink';
                        $this->typeflag = 'l';
                    } else {
                        $this->typename = 'File';
                        $this->typeflag = '-';
                    }
                } elseif ($this->is_dir) {
                    if ($this->is_link) {
                        $this->typename = 'Directory symlink';
                        $this->typeflag = 'l';
                    } else {
                        $this->typename = 'Directory';
                        $this->typeflag = 'd';
                    }
                }
                break;
        }

        $this->flags = array($this->typeflag);

        // User
        $this->flags[] = (($this->perms & 0400) ? 'r' : '-');
        $this->flags[] = (($this->perms & 0200) ? 'w' : '-');
        if ($this->perms & 0100) {
            $this->flags[] = ($this->perms & 04000) ? 's' : 'x';
        } else {
            $this->flags[] = ($this->perms & 04000) ? 'S' : '-';
        }

        // Group
        $this->flags[] = (($this->perms & 0040) ? 'r' : '-');
        $this->flags[] = (($this->perms & 0020) ? 'w' : '-');
        if ($this->perms & 0010) {
            $this->flags[] = ($this->perms & 02000) ? 's' : 'x';
        } else {
            $this->flags[] = ($this->perms & 02000) ? 'S' : '-';
        }

        // Other
        $this->flags[] = (($this->perms & 0004) ? 'r' : '-');
        $this->flags[] = (($this->perms & 0002) ? 'w' : '-');
        if ($this->perms & 0001) {
            $this->flags[] = ($this->perms & 01000) ? 's' : 'x';
        } else {
            $this->flags[] = ($this->perms & 01000) ? 'S' : '-';
        }

        $this->contents = \implode($this->flags).' '.$this->owner.' '.$this->group;
        $this->contents .= ' '.$this->getSize().' '.$this->getMTime().' ';

        if ($this->is_link && $this->linktarget) {
            $this->contents .= $this->path.' -> '.$this->linktarget;
        } elseif (null !== $this->realpath && \strlen($this->realpath) < \strlen($this->path)) {
            $this->contents .= $this->realpath;
        } else {
            $this->contents .= $this->path;
        }
    }

    public function getLabel()
    {
        return $this->typename.' ('.$this->getSize().')';
    }

    public function getSize()
    {
        if ($this->size) {
            $size = Utils::getHumanReadableBytes($this->size);

            return \round($size['value'], 2).$size['unit'];
        }
    }

    public function getMTime()
    {
        $year = \date('Y', $this->mtime);

        if ($year !== \date('Y')) {
            return \date('M d Y', $this->mtime);
        }

        return \date('M d H:i', $this->mtime);
    }
}