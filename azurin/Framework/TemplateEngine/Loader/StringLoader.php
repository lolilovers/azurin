<?php

namespace Azurin\Framework\TemplateEngine\Loader;

use Azurin\Framework\TemplateEngine\TemplateString;
use Azurin\Framework\TemplateEngine\Loader;

class StringLoader implements Loader
{
    /**
     * Load a Template by source.
     *
     * @param string $name Template source
     *
     * @return TemplateString Template source
     */
    public function load($name)
    {
        return new TemplateString($name);
    }
}