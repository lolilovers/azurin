<?php

namespace Kint\Parser;

use Kint\Object\BasicObject;
use Kint\Object\Representation\Representation;

class JsonPlugin extends Plugin
{
    public function getTypes()
    {
        return array('string');
    }

    public function getTriggers()
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, BasicObject &$o, $trigger)
    {
        if (!isset($var[0]) || ('{' !== $var[0] && '[' !== $var[0])) {
            return;
        }

        $json = \json_decode($var, true);

        if (!$json) {
            return;
        }

        $json = (array) $json;

        $base_obj = new BasicObject();
        $base_obj->depth = $o->depth;

        if ($o->access_path) {
            $base_obj->access_path = 'json_decode('.$o->access_path.', true)';
        }

        $r = new Representation('Json');
        $r->contents = $this->parser->parse($json, $base_obj);

        if (!\in_array('depth_limit', $r->contents->hints, true)) {
            $r->contents = $r->contents->value->contents;
        }

        $o->addRepresentation($r, 0);
    }
}
