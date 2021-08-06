<?php

namespace Src\Framework\DotEnv\Parser;

abstract class AbstractParser
{
    /**
     * The parent parser
     *
     * @var \M1\Env\Parser $parser
     */
    protected $parser;

    /**
     * The abstract parser constructor for Env
     *
     * @param \M1\Env\Parser $parser The parent parser
     */
    public function __construct($parser)
    {
        $this->parser = $parser;
    }
}
