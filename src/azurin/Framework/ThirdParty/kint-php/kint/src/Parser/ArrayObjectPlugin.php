<?php

namespace Kint\Parser;

use ArrayObject;
use Kint\Object\BasicObject;

class ArrayObjectPlugin extends Plugin
{
    public function getTypes()
    {
        return array('object');
    }

    public function getTriggers()
    {
        return Parser::TRIGGER_BEGIN;
    }

    public function parse(&$var, BasicObject &$o, $trigger)
    {
        if (!$var instanceof ArrayObject) {
            return;
        }

        $flags = $var->getFlags();

        if (ArrayObject::STD_PROP_LIST === $flags) {
            return;
        }

        $var->setFlags(ArrayObject::STD_PROP_LIST);

        $o = $this->parser->parse($var, $o);

        $var->setFlags($flags);

        $this->parser->haltParse();
    }
}
