<?php

namespace Azurin\Framework\TemplateEngine;

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