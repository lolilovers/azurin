<?php

namespace Kint\Object;

class InstanceObject extends BasicObject
{
    public $type = 'object';
    public $classname;
    public $hash;
    public $filename;
    public $startline;
    public $hints = array('object');

    public function getType()
    {
        return $this->classname;
    }

    public function transplant(BasicObject $old)
    {
        parent::transplant($old);

        if ($old instanceof self) {
            $this->classname = $old->classname;
            $this->hash = $old->hash;
            $this->filename = $old->filename;
            $this->startline = $old->startline;
        }
    }

    public static function sortByHierarchy($a, $b)
    {
        if (\is_string($a) && \is_string($b)) {
            $aclass = $a;
            $bclass = $b;
        } elseif (!($a instanceof BasicObject) || !($b instanceof BasicObject)) {
            return 0;
        } elseif ($a instanceof self && $b instanceof self) {
            $aclass = $a->classname;
            $bclass = $b->classname;
        } else {
            return 0;
        }

        if (\is_subclass_of($aclass, $bclass)) {
            return -1;
        }

        if (\is_subclass_of($bclass, $aclass)) {
            return 1;
        }

        return 0;
    }
}
