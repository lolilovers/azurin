<?php

namespace Src\Framework\TemplateEngine\Loader;

use Src\Framework\TemplateEngine\Loader;
use Src\Framework\TemplateEngine\TemplateString;

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
