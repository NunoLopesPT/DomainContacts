<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Datatypes\AuthenticationToken;

use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class AsymmetricCryptographyTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AsymmetricCryptographyTest extends AbstractTest
{
    /**
     * Test can create an AsymmetricCryptography
     *
     * @return void
     */
    public function testCanCreateAnAsymmetricCryptography(): void
    {
        // Create a dummy private key to test.
        $res = openssl_pkey_new();

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = \openssl_pkey_get_public(\openssl_pkey_get_details($res)['key']);
        $privKey = \openssl_pkey_get_private($res);

        // Performs test.
        $crypt = new AsymmetricCryptography($pubKey, $privKey);

        // Performs assertions.
        $this->assertEquals(
            $pubKey,
            $crypt->publicKey()
        );
        $this->assertEquals(
            $privKey,
            $crypt->privateKey()
        );
    }

    /**
     * Test cannot create an AsymmetrictCryptography if the given
     * arguments to the constructor are not resources.
     *
     * @return void
     */
    public function testCannotCreateAnAsymmetricCryptographyWithoutResourses(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        new AsymmetricCryptography('not a resource', 1);
    }
}
