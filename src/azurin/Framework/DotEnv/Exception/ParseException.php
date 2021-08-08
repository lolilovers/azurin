<?php

namespace Azurin\Framework\DotEnv\Exception;

class ParseException extends \ErrorException
{
    /**
     * Constructs a ParseException
     *
     * @param string $message          The value to parse
     * @param string $line             The line of the value
     * @param int    $line_num         The line num of the value
     */
    public function __construct($message, $line = null, $line_num = null)
    {
        $message = $this->createMessage($message, $line, $line_num);

        parent::__construct($message);
    }

    /**
     * Constructs a ParseException message
     *
     * @param string $message          The value to parse
     * @param string $line             The line of the value
     * @param int    $line_num         The line num of the value
     *
     * @return string The exception message
     */
    private function createMessage($message, $line, $line_num)
    {
        if (!is_null($line)) {
            $message .= sprintf(" near %s", $line);
        }

        if (!is_null($line_num)) {
            $message .= sprintf(" at line %d", $line_num);
        }

        return $message;
    }
}
