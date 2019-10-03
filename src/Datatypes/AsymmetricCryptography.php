<?php
namespace NunoLopes\DomainContacts\Datatypes;

/**
 * Class AsymmetricCryptography.
 *
 * This Datatype will carry an asymmetric cryptography with the
 * private and public key.
 *
 * @package NunoLopes\DomainContacts
 */
class AsymmetricCryptography
{
    /**
     * @var resource $publicKey - Public Key Resource.
     */
    private $publicKey;

    /**
     * @var resource $privateKey - Private Key Resource.
     */
    private $privateKey;

    /**
     * AsymmetricCryptography constructor.
     *
     * @throws \InvalidArgumentException
     *
     * @param resource $publicKey  - Public Key Resource.
     * @param resource $privateKey - Private Key Resource.
     */
    public function __construct($publicKey, $privateKey)
    {
        if (\is_resource($publicKey) && \is_resource($privateKey)) {
            throw new \InvalidArgumentException('Public and Private key must be resources.');
        }

        $this->publicKey  = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * Returns a public key resource.
     *
     * @return resource
     */
    public function publicKey()
    {
        return $this->publicKey;
    }

    /**
     * Returns a private key resource.
     *
     * @return resource
     */
    public function privateKey()
    {
        return $this->privateKey;
    }
}
