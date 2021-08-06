<?php

namespace Src\Framework\DotEnv\Parser;

use Src\Framework\DotEnv\Exception\ParseException;

class KeyParser extends AbstractParser
{
    /**
     * Parses a .env key
     *
     * @param string $key The key string
     *
     * @throws \M1\Env\Exception\ParseException If key contains a character that isn't alphanumeric or a _
     *
     * @return string|false The parsed key, or false if the key is a comment
     */
    public function parse($key)
    {
        $key = trim($key);

        if ($this->parser->string_helper->startsWith('#', $key)) {
            return false;
        }

        if (!ctype_alnum(str_replace('_', '', $key)) || $this->parser->string_helper->startsWithNumber($key)) {
            throw new ParseException(
                sprintf('Key can only contain alphanumeric and underscores and can not start with a number: %s', $key),
                $key,
                $this->parser->line_num
            );
        }

        return $key;
    }
}
