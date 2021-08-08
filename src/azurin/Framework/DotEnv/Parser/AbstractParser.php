<?php

namespace Azurin\Framework\DotEnv\Parser;

abstract class AbstractParser
{
    /**
     * The parent parser
     *
     * @var Parser $parser
     */
    protected $parser;

    /**
     * The abstract parser constructor for Env
     *
     * @param Parser $parser The parent parser
     */
    public function __construct($parser)
    {
        $this->parser = $parser;
    }
}
