<?php
declare(strict_types=1);

namespace Src\Framework\CSP\ConstantTime;

interface EncoderInterface
{
    /**
     * Convert a binary string into a hexadecimal string without cache-timing
     * leaks
     *
     * @param string $binString (raw binary)
     * @return string
     */
    public static function encode(string $binString): string;

    /**
     * Convert a binary string into a hexadecimal string without cache-timing
     * leaks
     *
     * @param string $encodedString
     * @param bool $strictPadding Error on invalid padding
     * @return string (raw binary)
     */
    public static function decode(string $encodedString, bool $strictPadding = false): string;
}
