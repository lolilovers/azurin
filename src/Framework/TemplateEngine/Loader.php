<?php

namespace Src\Framework\TemplateEngine;

interface Loader
{
    /**
     * Load a Template by name.
     *
     * @param string $name template name to load
     *
     * @return String
     */
    public function load($name);

}
