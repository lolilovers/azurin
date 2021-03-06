<?php

namespace Kint\Object;

use Kint\Object\Representation\Representation;
use Kint\Object\Representation\SourceRepresentation;
use ReflectionFunction;
use ReflectionMethod;

class TraceFrameObject extends BasicObject
{
    public $trace;
    public $hints = array('trace_frame');

    public function __construct(BasicObject $base, array $raw_frame)
    {
        parent::__construct();

        $this->transplant($base);

        $this->trace = array(
            'function' => isset($raw_frame['function']) ? $raw_frame['function'] : null,
            'line' => isset($raw_frame['line']) ? $raw_frame['line'] : null,
            'file' => isset($raw_frame['file']) ? $raw_frame['file'] : null,
            'class' => isset($raw_frame['class']) ? $raw_frame['class'] : null,
            'type' => isset($raw_frame['type']) ? $raw_frame['type'] : null,
            'object' => null,
            'args' => null,
        );

        if ($this->trace['class'] && \method_exists($this->trace['class'], $this->trace['function'])) {
            $func = new ReflectionMethod($this->trace['class'], $this->trace['function']);
            $this->trace['function'] = new MethodObject($func);
        } elseif (!$this->trace['class'] && \function_exists($this->trace['function'])) {
            $func = new ReflectionFunction($this->trace['function']);
            $this->trace['function'] = new MethodObject($func);
        }

        foreach ($this->value->contents as $frame_prop) {
            if ('object' === $frame_prop->name) {
                $this->trace['object'] = $frame_prop;
                $this->trace['object']->name = null;
                $this->trace['object']->operator = BasicObject::OPERATOR_NONE;
            }
            if ('args' === $frame_prop->name) {
                $this->trace['args'] = $frame_prop->value->contents;

                if ($this->trace['function'] instanceof MethodObject) {
                    foreach (\array_values($this->trace['function']->parameters) as $param) {
                        if (isset($this->trace['args'][$param->position])) {
                            $this->trace['args'][$param->position]->name = $param->getName();
                        }
                    }
                }
            }
        }

        $this->clearRepresentations();

        if (isset($this->trace['file'], $this->trace['line']) && \is_readable($this->trace['file'])) {
            $this->addRepresentation(new SourceRepresentation($this->trace['file'], $this->trace['line']));
        }

        if ($this->trace['args']) {
            $args = new Representation('Arguments');
            $args->contents = $this->trace['args'];
            $this->addRepresentation($args);
        }

        if ($this->trace['object']) {
            $callee = new Representation('object');
            $callee->label = 'Callee object ['.$this->trace['object']->classname.']';
            $callee->contents[] = $this->trace['object'];
            $this->addRepresentation($callee);
        }
    }
}
