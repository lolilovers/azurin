<?php

namespace Kint\Renderer\Rich;

use Kint\Object\BlobObject;
use Kint\Object\Representation\Representation;
use Kint\Renderer\RichRenderer;

class TablePlugin extends Plugin implements TabPluginInterface
{
    public static $respect_str_length = true;

    public function renderTab(Representation $r)
    {
        $out = '<pre><table><thead><tr><th></th>';

        $firstrow = \reset($r->contents);

        foreach ($firstrow->value->contents as $field) {
            $out .= '<th>'.$this->renderer->escape($field->name).'</th>';
        }

        $out .= '</tr></thead><tbody>';

        foreach ($r->contents as $row) {
            $out .= '<tr><th>';
            $out .= $this->renderer->escape($row->name);
            $out .= '</th>';

            foreach ($row->value->contents as $field) {
                $out .= '<td';
                $type = '';
                $size = '';
                $ref = '';

                if (null !== ($s = $field->getType())) {
                    $type = $this->renderer->escape($s);

                    if ($field->reference) {
                        $ref = '&amp;';
                        $type = $ref.$type;
                    }

                    if (null !== ($s = $field->getSize())) {
                        $size .= ' ('.$this->renderer->escape($s).')';
                    }
                }

                if ($type) {
                    $out .= ' title="'.$type.$size.'"';
                }

                $out .= '>';

                switch ($field->type) {
                    case 'boolean':
                        $out .= $field->value->contents ? '<var>'.$ref.'true</var>' : '<var>'.$ref.'false</var>';
                        break;
                    case 'integer':
                    case 'double':
                        $out .= (string) $field->value->contents;
                        break;
                    case 'null':
                        $out .= '<var>'.$ref.'null</var>';
                        break;
                    case 'string':
                        if ($field->encoding) {
                            $val = $field->value->contents;
                            if (RichRenderer::$strlen_max && self::$respect_str_length && BlobObject::strlen($val) > RichRenderer::$strlen_max) {
                                $val = \substr($val, 0, RichRenderer::$strlen_max).'...';
                            }

                            $out .= $this->renderer->escape($val);
                        } else {
                            $out .= '<var>'.$type.'</var>';
                        }
                        break;
                    case 'array':
                        $out .= '<var>'.$ref.'array</var>'.$size;
                        break;
                    case 'object':
                        $out .= '<var>'.$ref.$this->renderer->escape($field->classname).'</var>'.$size;
                        break;
                    case 'resource':
                        $out .= '<var>'.$ref.'resource</var>';
                        break;
                    default:
                        $out .= '<var>'.$ref.'unknown</var>';
                        break;
                }

                if (\in_array('blacklist', $field->hints, true)) {
                    $out .= ' <var>Blacklisted</var>';
                } elseif (\in_array('recursion', $field->hints, true)) {
                    $out .= ' <var>Recursion</var>';
                } elseif (\in_array('depth_limit', $field->hints, true)) {
                    $out .= ' <var>Depth Limit</var>';
                }

                $out .= '</td>';
            }

            $out .= '</tr>';
        }

        $out .= '</tbody></table></pre>';

        return $out;
    }
}
