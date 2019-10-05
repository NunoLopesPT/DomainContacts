<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Utilities\Signatures;

use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\DomainContacts\Utilities\Signatures\Sha256RsaSignature;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class Sha256RsaSignatureTest.
 *
 * @package NunoLopes\DomainContacts
 */
class Sha256RsaSignatureTest extends AbstractTest
{
    /**
     * @var RsaSignature $rsa - RSA Signature.
     */
    private $rsa = null;

    /**
     * @var AsymmetricCryptography $crypt -
     */
    private $crypt = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent.
        parent::setUp();

        // Dependencies to test.
        $this->rsa   = new Sha256RsaSignature();
        $this->crypt = $this->createSha256RsaCryptography();
    }

    /**
     * Creates a Sha256RsaCryptography for the tests.
     *
     * @return void
     */
    private function createSha256RsaCryptography(): AsymmetricCryptography
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
        $pubKey = \openssl_pkey_get_public(\openssl_pkey_get_details($res)['key']);
        $privKey = \openssl_pkey_get_private($res);

        // Performs test.
        return new AsymmetricCryptography($pubKey, $privKey);
    }

    /**
     * Test that a Base64 URL can be encoded and decoded.
     *
     * @return void
     */
    public function testCanSignAndVerifySha256Rsa(): void
    {
        // Dummy data to be signed/verified.
        $data = 'dummyData';

        // Sign the data.
        $signature = $this->rsa->sign($data, $this->crypt);

        // Verify the  data.
        $result = $this->rsa->verify($data, $signature, $this->crypt);

        // Perform assertion.
        $this->assertTrue(
            $result
        );
    }

    /**
     * Test a verification doesn't work if the RSA is different.
     *
     * @return void
     */
    public function testVerificationDontWorkWithOtherRsa(): void
    {
        // Signs an algorithm.
        $signature = $this->rsa->sign('dummyData', $this->crypt);

        // Verify with other key pair.
        $result = $this->rsa->verify(
            'dummyData',
            $signature,
            $this->createSha256RsaCryptography()
        );

        // Performs assertion.
        $this->assertFalse(
            $result
        );
    }

    /**
     * Test the Signature has always a code to compare later.
     *
     * @return void
     */
    public function testSha256RsaSignatureAlwaysHaveCode(): void
    {
        // Performs test.
        $signature = $this->rsa->code();

        // Performs assertion.
        $this->assertIsString(
            $signature
        );
        $this->assertEquals(
            $signature,
            'RS256'
        );
    }
}
