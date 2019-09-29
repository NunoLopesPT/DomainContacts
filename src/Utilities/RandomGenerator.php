<?php
namespace NunoLopes\DomainContacts\Utilities;

/**
 * Class RandomGenerator.
 *
 * This class is used to generate random variables.
 *
 * @package NunoLopes\DomainContacts
 */
class RandomGenerator
{
    /**
     * Renders a random string with a given length.
     *
     * @param int $length - Length of the bytes generated string.
     *
     * @throws \Exception - If it was not possible to gather sufficient entropy.
     *
     * @return string
     */
    public static function string(int $length = 40): string
    {
        // The length of the string won't be the same length,
        // because the generated string is in bytes, and with the conversion from
        // bin to hex the length is bigger.
        return \bin2hex(\random_bytes($length));
    }
}
