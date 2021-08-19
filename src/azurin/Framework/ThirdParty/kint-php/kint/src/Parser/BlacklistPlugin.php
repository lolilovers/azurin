<?php

namespace Kint\Parser;

use Kint\Object\BasicObject;
use Kint\Object\InstanceObject;

class BlacklistPlugin extends Plugin
{
    /**
     * List of classes and interfaces to blacklist.
     *
     * @var array
     */
    public static $blacklist = array();

    /**
     * List of classes and interfaces to blacklist except when dumped directly.
     *
     * @var array
     */
    public static $shallow_blacklist = array();

    /**
     * Maximum size of arrays before blacklisting.
     *
     * @var int
     */
    public static $array_limit = 10000;

    /**
     * Maximum size of arrays before blacklisting except when dumped directly.
     *
     * @var int
     */
    public static $shallow_array_limit = 1000;

    public function getTypes()
    {
        return array('object', 'array');
    }

    public function getTriggers()
    {
        return Parser::TRIGGER_BEGIN;
    }

    public function parse(&$var, BasicObject &$o, $trigger)
    {
        if (\is_object($var)) {
            return $this->parseObject($var, $o);
        }
        if (\is_array($var)) {
            return $this->parseArray($var, $o);
        }
    }

    protected function parseObject(&$var, BasicObject &$o)
    {
        foreach (self::$blacklist as $class) {
            if ($var instanceof $class) {
                return $this->blacklistObject($var, $o);
            }
        }

        if ($o->depth <= 0) {
            return;
        }

        foreach (self::$shallow_blacklist as $class) {
            if ($var instanceof $class) {
                return $this->blacklistObject($var, $o);
            }
        }
    }

    protected function blacklistObject(&$var, BasicObject &$o)
    {
        $object = new InstanceObject();
        $object->transplant($o);
        $object->classname = \get_class($var);
        $object->hash = \spl_object_hash($var);
        $object->clearRepresentations();
        $object->value = null;
        $object->size = null;
        $object->hints[] = 'blacklist';

        $o = $object;

        $this->parser->haltParse();
    }

    protected function parseArray(array &$var, BasicObject &$o)
    {
        if (\count($var) > self::$array_limit) {
            return $this->blacklistArray($var, $o);
        }

        if ($o->depth <= 0) {
            return;
        }

        if (\count($var) > self::$shallow_array_limit) {
            return $this->blacklistArray($var, $o);
        }
    }

    protected function blacklistArray(array &$var, BasicObject &$o)
    {
        $object = new BasicObject();
        $object->transplant($o);
        $object->value = null;
        $object->size = \count($var);
        $object->hints[] = 'blacklist';

        $o = $object;

        $this->parser->haltParse();
    }
}
