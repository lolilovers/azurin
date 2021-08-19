<?php

namespace Kint\Renderer\Rich;

use Kint\Object\BasicObject;
use Kint\Object\BlobObject;
use Kint\Renderer\RichRenderer;

class SimpleXMLElementPlugin extends Plugin implements ObjectPluginInterface
{
    public function renderObject(BasicObject $o)
    {
        $children = $this->renderer->renderChildren($o);

        $header = '';

        if (null !== ($s = $o->getModifiers())) {
            $header .= '<var>'.$s.'</var> ';
        }

        if (null !== ($s = $o->getName())) {
            $header .= '<dfn>'.$this->renderer->escape($s).'</dfn> ';

            if ($s = $o->getOperator()) {
                $header .= $this->renderer->escape($s, 'ASCII').' ';
            }
        }

        if (null !== ($s = $o->getType())) {
            $s = $this->renderer->escape($s);

            if ($o->reference) {
                $s = '&amp;'.$s;
            }

            $header .= '<var>'.$this->renderer->escape($s).'</var> ';
        }

        if (null !== ($s = $o->getSize())) {
            $header .= '('.$this->renderer->escape($s).') ';
        }

        if (null === $s && $c = $o->getRepresentation('contents')) {
            $c = \reset($c->contents);

            if ($c && null !== ($s = $c->getValueShort())) {
                if (RichRenderer::$strlen_max && BlobObject::strlen($s) > RichRenderer::$strlen_max) {
                    $s = \substr($s, 0, RichRenderer::$strlen_max).'...';
                }
                $header .= $this->renderer->escape($s);
            }
        }

        $header = $this->renderer->renderHeaderWrapper($o, (bool) \strlen($children), $header);

        return '<dl>'.$header.$children.'</dl>';
    }
}
