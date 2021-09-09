<?php

namespace Azurin\Framework\TemplateEngine;

class TemplateString
{
    private $string = "";

    /**
     * Create new string
     *
     * @param string $string input source
     */
    public function __construct($string)
    {
        $this->setString($string);
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getString();
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Create new string
     *
     * @param string $string input source
     *
     * @return void
     */
    public function setString($string)
    {
        $this->string = $string;
    }
}