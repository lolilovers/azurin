<?php

namespace Kint\Renderer\Rich;

use Kint\Kint;
use Kint\Object\BasicObject;
use Kint\Object\ClosureObject;

class ClosurePlugin extends Plugin implements ObjectPluginInterface
{
    public function renderObject(BasicObject $o)
    {
        $children = $this->renderer->renderChildren($o);

        if (!($o instanceof ClosureObject)) {
            $header = $this->renderer->renderHeader($o);
        } else {
            $header = '';

            if (null !== ($s = $o->getModifiers())) {
                $header .= '<var>'.$s.'</var> ';
            }

            if (null !== ($s = $o->getName())) {
                $header .= '<dfn>'.$this->renderer->escape($s).'('.$this->renderer->escape($o->getParams()).')</dfn> ';
            }

            $header .= '<var>Closure</var> ';
            $header .= $this->renderer->escape(Kint::shortenPath($o->filename)).':'.(int) $o->startline;
        }

        $header = $this->renderer->renderHeaderWrapper($o, (bool) \strlen($children), $header);

        return '<dl>'.$header.$children.'</dl>';
    }
}
