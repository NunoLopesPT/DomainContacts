<?php
namespace NunoLopes\DomainContacts\Utilities;

use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;

/**
 * Class Sha256Signature.
 *
 * @package NunoLopes\DomainContacts
 */
class Sha256RsaSignature implements RsaSignature
{
    /**
     * @var string CODE - Digest Code.
     */
    private const CODE = 'RS256';

    /**
     * Returns the Digest code of this class.
     *
     * @return string
     */
    public function code(): string
    {
        return self::CODE;
    }

    /**
     * Verify the signature.
     *
     * @param string $data
     * @param string $signature
     *
     * @return bool
     */
    public function verify(string $data, string $signature, string $publicKeyPath): bool
    {
        $result = \openssl_verify(
            $data,
            $signature,
            \openssl_pkey_get_public($publicKeyPath),
            'sha256'
        );

        if ($result === -1)
        {
            // @todo throw Signature not valid
        }

        return \boolval($result);
    }

    /**
     * Creates a new signature and returns the result.
     *
     * @param string $data           - The data that is going to be signed.
     * @param string $privateKeyPath - Private Key path.
     *
     * @return string
     */
    public function sign(string $data, string $privateKeyPath): string
    {
        $success = \openssl_sign(
            $data,
            $signature,
            \openssl_pkey_get_private($privateKeyPath),
            'sha256WithRSAEncryption'
        );

        if (!$success) {
            // throw exception
        }

        return $signature;
    }
}
