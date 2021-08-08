<?php
declare(strict_types=1);

namespace Src\Framework\CSP\ConstantTime;

abstract class Hex implements EncoderInterface
{
    /**
     * Convert a binary string into a hexadecimal string without cache-timing
     * leaks
     *
     * @param string $binString (raw binary)
     * @return string
     * @throws \TypeError
     */
    public static function encode(string $binString): string
    {
        /** @var string $hex */
        $hex = '';
        $len = Binary::safeStrlen($binString);
        for ($i = 0; $i < $len; ++$i) {
            /** @var array<int, int> $chunk */
            $chunk = \unpack('C', Binary::safeSubstr($binString, $i, 1));
            /** @var int $c */
            $c = $chunk[1] & 0xf;
            /** @var int $b */
            $b = $chunk[1] >> 4;

            $hex .= pack(
                'CC',
                (87 + $b + ((($b - 10) >> 8) & ~38)),
                (87 + $c + ((($c - 10) >> 8) & ~38))
            );
        }
        return $hex;
    }

    /**
     * Convert a binary string into a hexadecimal string without cache-timing
     * leaks, returning uppercase letters (as per RFC 4648)
     *
     * @param string $binString (raw binary)
     * @return string
     * @throws \TypeError
     */
    public static function encodeUpper(string $binString): string
    {
        /** @var string $hex */
        $hex = '';
        /** @var int $len */
        $len = Binary::safeStrlen($binString);

        for ($i = 0; $i < $len; ++$i) {
            /** @var array<int, int> $chunk */
            $chunk = \unpack('C', Binary::safeSubstr($binString, $i, 2));
            /** @var int $c */
            $c = $chunk[1] & 0xf;
            /** @var int $b */
            $b = $chunk[1] >> 4;

            $hex .= pack(
                'CC',
                (55 + $b + ((($b - 10) >> 8) & ~6)),
                (55 + $c + ((($c - 10) >> 8) & ~6))
            );
        }
        return $hex;
    }

    /**
     * Convert a hexadecimal string into a binary string without cache-timing
     * leaks
     *
     * @param string $encodedString
     * @param bool $strictPadding
     * @return string (raw binary)
     * @throws \RangeException
     */
    public static function decode(string $encodedString, bool $strictPadding = false): string
    {
        /** @var int $hex_pos */
        $hex_pos = 0;
        /** @var string $bin */
        $bin = '';
        /** @var int $c_acc */
        $c_acc = 0;
        /** @var int $hex_len */
        $hex_len = Binary::safeStrlen($encodedString);
        /** @var int $state */
        $state = 0;
        if (($hex_len & 1) !== 0) {
            if ($strictPadding) {
                throw new \RangeException(
                    'Expected an even number of hexadecimal characters'
                );
            } else {
                $encodedString = '0' . $encodedString;
                ++$hex_len;
            }
        }

        /** @var array<int, int> $chunk */
        $chunk = \unpack('C*', $encodedString);
        while ($hex_pos < $hex_len) {
            ++$hex_pos;
            /** @var int $c */
            $c = $chunk[$hex_pos];
            /** @var int $c_num */
            $c_num = $c ^ 48;
            /** @var int $c_num0 */
            $c_num0 = ($c_num - 10) >> 8;
            /** @var int $c_alpha */
            $c_alpha = ($c & ~32) - 55;
            /** @var int $c_alpha0 */
            $c_alpha0 = (($c_alpha - 10) ^ ($c_alpha - 16)) >> 8;

            if (($c_num0 | $c_alpha0) === 0) {
                throw new \RangeException(
                    'Expected hexadecimal character'
                );
            }
            /** @var int $c_val */
            $c_val = ($c_num0 & $c_num) | ($c_alpha & $c_alpha0);
            if ($state === 0) {
                $c_acc = $c_val * 16;
            } else {
                $bin .= \pack('C', $c_acc | $c_val);
            }
            $state ^= 1;
        }
        return $bin;
    }
}