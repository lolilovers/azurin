<?php
declare(strict_types=1);

namespace Src\Framework\CSP\ConstantTime;

abstract class RFC4648
{
    /**
     * RFC 4648 Base64 encoding
     *
     * "foo" -> "Zm9v"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base64Encode(string $str): string
    {
        return Base64::encode($str);
    }

    /**
     * RFC 4648 Base64 decoding
     *
     * "Zm9v" -> "foo"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base64Decode(string $str): string
    {
        return Base64::decode($str, true);
    }

    /**
     * RFC 4648 Base64 (URL Safe) encoding
     *
     * "foo" -> "Zm9v"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base64UrlSafeEncode(string $str): string
    {
        return Base64UrlSafe::encode($str);
    }

    /**
     * RFC 4648 Base64 (URL Safe) decoding
     *
     * "Zm9v" -> "foo"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base64UrlSafeDecode(string $str): string
    {
        return Base64UrlSafe::decode($str, true);
    }

    /**
     * RFC 4648 Base32 encoding
     *
     * "foo" -> "MZXW6==="
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base32Encode(string $str): string
    {
        return Base32::encodeUpper($str);
    }

    /**
     * RFC 4648 Base32 encoding
     *
     * "MZXW6===" -> "foo"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base32Decode(string $str): string
    {
        return Base32::decodeUpper($str, true);
    }

    /**
     * RFC 4648 Base32-Hex encoding
     *
     * "foo" -> "CPNMU==="
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base32HexEncode(string $str): string
    {
        return Base32::encodeUpper($str);
    }

    /**
     * RFC 4648 Base32-Hex decoding
     *
     * "CPNMU===" -> "foo"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base32HexDecode(string $str): string
    {
        return Base32::decodeUpper($str, true);
    }

    /**
     * RFC 4648 Base16 decoding
     *
     * "foo" -> "666F6F"
     *
     * @param string $str
     * @return string
     * @throws \TypeError
     */
    public static function base16Encode(string $str): string
    {
        return Hex::encodeUpper($str);
    }

    /**
     * RFC 4648 Base16 decoding
     *
     * "666F6F" -> "foo"
     *
     * @param string $str
     * @return string
     */
    public static function base16Decode(string $str): string
    {
        return Hex::decode($str, true);
    }
}