<?php
namespace NunoLopes\DomainContacts\Utilities\Signatures;

use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;

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
     * @inheritdoc
     */
    public function code(): string
    {
        return self::CODE;
    }

    /**
     * @inheritdoc
     */
    public function verify(string $data, string $signature, AsymmetricCryptography $crypt): bool
    {
        $result = \openssl_verify(
            $data,
            $signature,
            $crypt->publicKey(),
            'sha256'
        );

        if ($result === -1)
        {
            // @todo throw Signature not valid
        }

        return \boolval($result);
    }

    /**
     * @inheritdoc
     */
    public function sign(string $data, AsymmetricCryptography $crypt): string
    {
        $success = \openssl_sign(
            $data,
            $signature,
            $crypt->privateKey(),
            'sha256WithRSAEncryption'
        );

        if (!$success) {
            // throw exception
        }

        return $signature;
    }
}
