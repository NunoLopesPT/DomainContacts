<?php
namespace NunoLopes\DomainContacts\Utilities;

/**
 * Class RandomGenerator.
 *
 * This class is used to generate random variables.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class RandomGenerator
{
    /**
     * Renders a random string with a given length.
     *
     * @param int $length - Length of the string.
     *
     * @throws \Exception - If it was not possible to gather sufficient entropy.
     *
     * @return string
     */
    public static function string(int $length = 40): string
    {
        return \bin2hex(\random_bytes($length));
    }
}
