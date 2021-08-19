<?php

namespace Kint\Object;

use Kint\Utils;
use ReflectionException;
use ReflectionParameter;

class ParameterObject extends BasicObject
{
    public $type_hint;
    public $default;
    public $position;
    public $hints = array('parameter');

    public function __construct(ReflectionParameter $param)
    {
        parent::__construct();

        if (KINT_PHP70) {
            if ($type = $param->getType()) {
                $this->type_hint = Utils::getTypeString($type);
            }
        } else {
            if ($param->isArray()) {
                $this->type_hint = 'array';
            } else {
                try {
                    if ($this->type_hint = $param->getClass()) {
                        $this->type_hint = $this->type_hint->name;
                    }
                } catch (ReflectionException $e) {
                    \preg_match('/\\[\\s\\<\\w+?>\\s([\\w]+)/s', $param->__toString(), $matches);
                    $this->type_hint = isset($matches[1]) ? $matches[1] : '';
                }
            }
        }

        $this->reference = $param->isPassedByReference();
        $this->name = $param->getName();
        $this->position = $param->getPosition();

        if ($param->isDefaultValueAvailable()) {
            /** @var mixed Psalm bug workaround */
            $default = $param->getDefaultValue();
            switch (\gettype($default)) {
                case 'NULL':
                    $this->default = 'null';
                    break;
                case 'boolean':
                    $this->default = $default ? 'true' : 'false';
                    break;
                case 'array':
                    $this->default = \count($default) ? 'array(...)' : 'array()';
                    break;
                default:
                    $this->default = \var_export($default, true);
                    break;
            }
        }
    }

    public function getType()
    {
        return $this->type_hint;
    }

    public function getName()
    {
        return '$'.$this->name;
    }

    public function getDefault()
    {
        return $this->default;
    }
}
