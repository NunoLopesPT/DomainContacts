<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

interface AsymmetricCryptography
{
    /**
     * Returns the server's public key path.
     *
     * @return string
     */
    public function publicKeyPath(): string;

    /**
     * Returns the server's private key path.
     *
     * @return string
     */
    public function privateKeyPath(): string;
}
