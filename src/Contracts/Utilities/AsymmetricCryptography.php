<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

interface AsymmetricCryptography
{
    /**
     * Returns a public key resource.
     *
     * @return resource
     */
    public function publicKey();

    /**
     * Returns a private key resource.
     *
     * @return resource
     */
    public function privateKey();
}
