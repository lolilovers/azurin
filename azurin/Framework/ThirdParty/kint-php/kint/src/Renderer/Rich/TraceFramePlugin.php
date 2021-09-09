<?php

namespace Kint\Renderer\Rich;

use Kint\Object\BasicObject;
use Kint\Object\TraceFrameObject;

class TraceFramePlugin extends Plugin implements ObjectPluginInterface
{
    public function renderObject(BasicObject $o)
    {
        if (!$o instanceof TraceFrameObject) {
            return;
        }

        if (!empty($o->trace['file']) && !empty($o->trace['line'])) {
            $header = '<var>'.$this->renderer->ideLink($o->trace['file'], (int) $o->trace['line']).'</var> ';
        } else {
            $header = '<var>PHP internal call</var> ';
        }

        if ($o->trace['class']) {
            $header .= $this->renderer->escape($o->trace['class'].$o->trace['type']);
        }

        if (\is_string($o->trace['function'])) {
            $function = $this->renderer->escape($o->trace['function'].'()');
        } else {
            $function = $this->renderer->escape(
                $o->trace['function']->getName().'('.$o->trace['function']->getParams().')'
            );

            if (null !== ($url = $o->trace['function']->getPhpDocUrl())) {
                $function = '<a href="'.$url.'" target=_blank>'.$function.'</a>';
            }
        }

        $header .= '<dfn>'.$function.'</dfn>';

        $children = $this->renderer->renderChildren($o);
        $header = $this->renderer->renderHeaderWrapper($o, (bool) \strlen($children), $header);

        return '<dl>'.$header.$children.'</dl>';
    }
}
