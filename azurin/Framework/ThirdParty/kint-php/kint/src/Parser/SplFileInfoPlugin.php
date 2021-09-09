<?php

namespace Kint\Parser;

use Kint\Object\BasicObject;
use Kint\Object\Representation\SplFileInfoRepresentation;
use SplFileInfo;
use SplFileObject;

class SplFileInfoPlugin extends Plugin
{
    public function getTypes()
    {
        return array('object');
    }

    public function getTriggers()
    {
        return Parser::TRIGGER_COMPLETE;
    }

    public function parse(&$var, BasicObject &$o, $trigger)
    {
        if (!$var instanceof SplFileInfo || $var instanceof SplFileObject) {
            return;
        }

        $r = new SplFileInfoRepresentation(clone $var);
        $o->addRepresentation($r, 0);
        $o->size = $r->getSize();
    }
}
