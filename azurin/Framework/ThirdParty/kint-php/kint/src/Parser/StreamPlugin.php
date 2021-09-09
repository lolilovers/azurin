<?php

namespace Kint\Parser;

use Kint\Object\BasicObject;
use Kint\Object\Representation\Representation;
use Kint\Object\ResourceObject;
use Kint\Object\StreamObject;

class StreamPlugin extends Plugin
{
    public function getTypes()
    {
        return array('resource');
    }

    public function getTriggers()
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, BasicObject &$o, $trigger)
    {
        if (!$o instanceof ResourceObject || 'stream' !== $o->resource_type) {
            return;
        }

        if (!$meta = \stream_get_meta_data($var)) {
            return;
        }

        $rep = new Representation('Stream');
        $rep->implicit_label = true;

        $base_obj = new BasicObject();
        $base_obj->depth = $o->depth;

        if ($o->access_path) {
            $base_obj->access_path = 'stream_get_meta_data('.$o->access_path.')';
        }

        $rep->contents = $this->parser->parse($meta, $base_obj);

        if (!\in_array('depth_limit', $rep->contents->hints, true)) {
            $rep->contents = $rep->contents->value->contents;
        }

        $o->addRepresentation($rep, 0);
        $o->value = $rep;

        $stream = new StreamObject($meta);
        $stream->transplant($o);
        $o = $stream;
    }
}
