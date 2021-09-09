<?php

namespace Kint\Renderer\Rich;

use Kint\Object\Representation\Representation;
use Kint\Object\Representation\SourceRepresentation;

class SourcePlugin extends Plugin implements TabPluginInterface
{
    public function renderTab(Representation $r)
    {
        if (!($r instanceof SourceRepresentation) || empty($r->source)) {
            return false;
        }

        $source = $r->source;

        // Trim empty lines from the start and end of the source
        foreach ($source as $linenum => $line) {
            if (\strlen(\trim($line)) || $linenum === $r->line) {
                break;
            }

            unset($source[$linenum]);
        }

        foreach (\array_reverse($source, true) as $linenum => $line) {
            if (\strlen(\trim($line)) || $linenum === $r->line) {
                break;
            }

            unset($source[$linenum]);
        }

        $output = '';

        foreach ($source as $linenum => $line) {
            if ($linenum === $r->line) {
                $output .= '<div class="kint-highlight">'.$this->renderer->escape($line)."\n".'</div>';
            } else {
                $output .= '<div>'.$this->renderer->escape($line)."\n".'</div>';
            }
        }

        if ($output) {
            \reset($source);

            $data = '';
            if ($r->showfilename) {
                $data = ' data-kint-filename="'.$this->renderer->escape($r->filename).'"';
            }

            return '<div><pre class="kint-source"'.$data.' style="counter-reset: kint-l '.((int) \key($source) - 1).';">'.$output.'</pre></div><div></div>';
        }
    }
}
