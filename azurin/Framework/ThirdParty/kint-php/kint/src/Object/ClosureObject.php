<?php

namespace Kint\Object;

class ClosureObject extends InstanceObject
{
    public $parameters = array();
    public $hints = array('object', 'callable', 'closure');

    private $paramcache;

    public function getAccessPath()
    {
        if (null !== $this->access_path) {
            return parent::getAccessPath().'('.$this->getParams().')';
        }
    }

    public function getSize()
    {
    }

    public function getParams()
    {
        if (null !== $this->paramcache) {
            return $this->paramcache;
        }

        $out = array();

        foreach ($this->parameters as $p) {
            $type = $p->getType();

            $ref = $p->reference ? '&' : '';

            if ($type) {
                $out[] = $type.' '.$ref.$p->getName();
            } else {
                $out[] = $ref.$p->getName();
            }
        }

        return $this->paramcache = \implode(', ', $out);
    }
}
