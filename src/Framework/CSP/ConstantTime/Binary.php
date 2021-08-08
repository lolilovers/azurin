<?php
declare(strict_types=1);

namespace Src\Framework\CSP\ConstantTime;

abstract class Binary
{
    /**
     * Safe string length
     *
     * @ref mbstring.func_overload
     *
     * @param string $str
     * @return int
     */
    public static function safeStrlen(string $str): int
    {
        if (\function_exists('mb_strlen')) {
            return (int) \mb_strlen($str, '8bit');
        } else {
            return \strlen($str);
        }
    }

    /**
     * Safe substring
     *
     * @ref mbstring.func_overload
     *
     * @staticvar boolean $exists
     * @param string $str
     * @param int $start
     * @param int $length
     * @return string
     * @throws \TypeError
     */
    public static function safeSubstr(
        string $str,
        int $start = 0,
        $length = null
    ): string {
        if ($length === 0) {
            return '';
        }
        if (\function_exists('mb_substr')) {
            return \mb_substr($str, $start, $length, '8bit');
        }
        // Unlike mb_substr(), substr() doesn't accept NULL for length
        if ($length !== null) {
            return \substr($str, $start, $length);
        } else {
            return \substr($str, $start);
        }
    }
}
