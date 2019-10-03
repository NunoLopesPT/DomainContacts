<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

/**
 * Interface RsaSignature.
 *
 * This contract will be responsible for verification and
 * sign of a Cryptographic Hash Algorithm.
 *
 * All signatures should implement this class.
 *
 * @package NunoLopes\DomainContacts\Utilities\Signatures
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
     * Creates a new KeyPair and returns the private and the public
     * key in a DataType.
     *
     * @return AsymmetricCryptography
     */
    public function create(): string;

    /**
     * Verifies a signature.
     *
     * @param string $data          - Original data.
     * @param string $signature     - Signature of the data.
     * @param string $publicKeyPath - Path of the public key that was used when the signature was created.
     *
     * @return bool
     */
    public function verify(string $data, string $signature, string $publicKeyPath): bool;

    /**
     * Get the signature of a data.
     *
     * @param string $data           - Data that will be retrieved a signature.
     * @param string $privateKeyPath - Path of a private key to generate the signature.
     *
     * @return string
     */
    public function sign(string $data, string $privateKeyPath): string;
}
