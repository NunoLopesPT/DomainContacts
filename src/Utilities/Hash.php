<?php
namespace NunoLopes\DomainContacts\Utilities;

/**
 * Class Hash.
 *
 * This class will provide helpful functions related with hashes.
 *
 * @package NunoLopes\DomainContacts
 */
class Hash
{
    /**
     * Check if a given string matches an hash.
     *
     * @param string $string - String that will be hashed and then compared.
     * @param string $hash   - Hash that is going to be compared.
     *
     * @throws \InvalidArgumentException - If the string or the hash is an empty string.
     *
     * @return bool
     */
    public static function verify(string $string, string $hash): bool
    {
        // Throw exception if the email is empty.
        if (\strlen(\trim($string)) === 0 || \strlen(\trim($hash)) === 0) {
            throw new \InvalidArgumentException('The string to verify or the hash is an empty string.');
        }

        return \password_verify($string, $hash);
    }

    /**
     * Creates an hash from a given string.
     *
     * @param string     $string    - String that we will create the hash from.
     * @param int|null   $algorithm - The algorithm to create the hash (See link).
     * @param array|null $options   - An associative array containing options (See link).
     *
     * @throws \InvalidArgumentException - If the string to create an hash is an empty string.
     *
     * @see http://www.php.net/manual/en/password.constants.php
     *
     * @return string
     */
    public static function create(string $string, int $algorithm = PASSWORD_BCRYPT, array $options = []): string
    {
        // Throw exception if the email is empty.
        if (\strlen(\trim($string)) === 0) {
            throw new \InvalidArgumentException('The string to create an hash is an empty string.');
        }

        return \password_hash($string, $algorithm, $options);
    }
}
