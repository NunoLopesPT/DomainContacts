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
     * Returns the Digest code of this class.
     *
     * @return string
     */
    public function code(): string
    {
        return self::CODE;
    }

    /**
     * Creates a new KeyPair and returns the private and the public
     * key in a DataType.
     *
     * @return AsymmetricCryptography
     */
    public function create(): AsymmetricCryptography
    {
        $config = array(
            "digest_alg"       => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        return new AsymmetricCryptography(
            $pubKey,
            $privKey
        );
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
