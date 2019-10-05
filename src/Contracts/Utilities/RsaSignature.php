<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;

/**
 * Interface RsaSignature.
 *
 * This contract will be responsible for verification and
 * sign of a Cryptographic Hash Algorithm.
 *
 * All signatures should implement this class.
 *
 * @package NunoLopes\DomainContacts
 */
interface RsaSignature
{
    /**
     * Returns the code of the signature.
     *
     * @return string
     */
    public function code(): string;

    /**
     * Verifies a signature.
     *
     * @param string                 $data      - Original data.
     * @param string                 $signature - Signature of the data.
     * @param AsymmetricCryptography $crypt     - RSA Key Pair.
     *
     * @return bool
     */
    public function verify(string $data, string $signature, AsymmetricCryptography $crypt): bool;

    /**
     * Get the signature of a data.
     *
     * @param string                 $data  - Data that will be retrieved a signature.
     * @param AsymmetricCryptography $crypt - RSA Key Pair.
     *
     * @return string
     */
    public function sign(string $data, AsymmetricCryptography $crypt): string;
}
