<?php

/**
 * ===========================
 * Files
 * ===========================
 */

namespace Azurin\Framework\Services;

class Files
{
    public function getInfo($file)
    {
        // Get file info
        $data   = [
            'name'      => $_FILES[$file]['name'] ?: null,
            'type'      => $_FILES[$file]['type'] ?: null,
            'size'      => $_FILES[$file]['size'] ?: null,
            'tmp_name'  => $_FILES[$file]['tmp_name'] ?: null,
            'error'     => $_FILES[$file]['error'] ?: null
        ];

        return $data;
    }

    public function upload($file, $target)
    {
        // Directory
        $target_dir     = $target;
        $target_file    = $target_dir . basename($_FILES[$file]["name"]);

        // Move file
        if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function scan($dir)
    {
        // Scan files and folder in $dir
        $files	= array_slice(scandir($dir), 2);

        return $files;
    }

    public function delete($name, $dir)
    {
        // Separate file name and directory
        $file = $dir . $name;

        return unlink($file);
    }

    public function exist($name, $dir)
    {
        // Separate file name and directory
        $file = $dir . $name;

        return file_exists($file);
    }

    public function rename($old, $new, $dir)
    {
        // More easier way to rename file in same directory
        $oldName = $dir . $old;
        $newName = $dir . $new;

        return rename($oldName, $newName);
    }
}