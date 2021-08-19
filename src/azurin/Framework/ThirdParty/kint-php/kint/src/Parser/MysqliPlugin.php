<?php

namespace Kint\Parser;

use Kint\Object\BasicObject;
use Mysqli;

/**
 * Adds support for Mysqli object parsing.
 *
 * Due to the way mysqli is implemented in PHP, this will cause
 * warnings on certain Mysqli objects if screaming is enabled.
 */
class MysqliPlugin extends Plugin
{
    // These 'properties' are actually globals
    protected $always_readable = array(
        'client_version' => true,
        'connect_errno' => true,
        'connect_error' => true,
    );

    // These are readable on empty mysqli objects, but not on failed connections
    protected $empty_readable = array(
        'client_info' => true,
        'errno' => true,
        'error' => true,
    );

    // These are only readable on connected mysqli objects
    protected $connected_readable = array(
        'affected_rows' => true,
        'error_list' => true,
        'field_count' => true,
        'host_info' => true,
        'info' => true,
        'insert_id' => true,
        'server_info' => true,
        'server_version' => true,
        'stat' => true,
        'sqlstate' => true,
        'protocol_version' => true,
        'thread_id' => true,
        'warning_count' => true,
    );

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
        if (!$var instanceof Mysqli) {
            return;
        }

        $connected = false;
        $empty = false;

        if (\is_string(@$var->sqlstate)) {
            $connected = true;
        } elseif (\is_string(@$var->client_info)) {
            $empty = true;
        }

        foreach ($o->value->contents as $key => $obj) {
            if (isset($this->connected_readable[$obj->name])) {
                if (!$connected) {
                    continue;
                }
            } elseif (isset($this->empty_readable[$obj->name])) {
                if (!$connected && !$empty) {
                    continue;
                }
            } elseif (!isset($this->always_readable[$obj->name])) {
                continue;
            }

            if ('null' !== $obj->type) {
                continue;
            }

            $param = $var->{$obj->name};

            if (null === $param) {
                continue;
            }

            $base = BasicObject::blank($obj->name, $obj->access_path);

            $base->depth = $obj->depth;
            $base->owner_class = $obj->owner_class;
            $base->operator = $obj->operator;
            $base->access = $obj->access;
            $base->reference = $obj->reference;

            $o->value->contents[$key] = $this->parser->parse($param, $base);
        }
    }
}
