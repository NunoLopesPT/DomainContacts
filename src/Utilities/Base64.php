<?php
namespace NunoLopes\DomainContacts\Utilities;

/**
 * Class Base64.
 *
 * This class will provide helpful functions related with Base64.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class Base64 {

    /**
     * Decodes data in Base64Url variation.
     *
     * @param string $data - That that is going to be decoded.
     *
     * @return string
     */
    public static function urlDecode(string $data): string
    {
        $urlUnsafeData = \strtr($data, '-_', '+/');

        $paddedData = \str_pad($urlUnsafeData, \strlen($data) % 4, '=', STR_PAD_RIGHT);

        return \base64_decode($paddedData);
    }

    /**
     * Encodes data in Base64Url variation.
     *
     * @param string $data - That that is going to be encoded.
     *
     * @return string
     */
    public static function urlEncode(string $data): string
    {
        $urlSafeData = \strtr(\base64_encode($data), '+/', '-_');

        return \rtrim($urlSafeData, '=');
    }
}
