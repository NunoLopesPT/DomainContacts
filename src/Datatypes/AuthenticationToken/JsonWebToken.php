<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;

use NunoLopes\DomainContacts\Contracts\Utilities\AsymmetricCryptography;
use NunoLopes\DomainContacts\Utilities\Base64;

/**
 * Class JsonWebToken.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class JsonWebToken
{
    /**
     * @var JwtHeader $header - JWT Header.
     */
    private $header = null;

    /**
     * @var JwtPayload $payload - JWT Payload.
     */
    private $payload = null;

    /**
     * @var AsymmetricCryptography - Asymmetric Cryptography instance.
     */
    private $asymmetricCryptography = null;

    /**
     * @var string $signature - Signature of the JWT.
     */
    private $signature = null;

    /**
     * JsonWebToken constructor.
     *
     * @todo Set this constructor without arguments.
     *
     * @param JwtHeader              $header                 - JWT Header instance.
     * @param JwtPayload             $payload                - JWT Payload instance.
     * @param AsymmetricCryptography $asymmetricCryptography - Asymmetric Cryptography instance.
     */
    public function __construct(
        JwtHeader $header,
        JwtPayload $payload,
        AsymmetricCryptography $asymmetricCryptography
    ) {
        $this->header = $header;
        $this->payload = $payload;
        $this->asymmetricCryptography = $asymmetricCryptography;
    }

    /**
     * Returns the JWT Header instance.
     *
     * @return JwtHeader
     */
    public function header(): JwtHeader
    {
        return $this->header;
    }

    /**
     * Returns the JWT Payload instance.
     *
     * @return JwtPayload
     */
    public function payload(): JwtPayload
    {
        return $this->payload;
    }

    /**
     * Returns the Header encoded.
     *
     * @return string
     */
    public function headerEncoded(): string
    {
        return $this->header->encoded();
    }

    /**
     * Returns the Payload encoded.
     *
     * @return string
     */
    public function payloadEncoded(): string
    {
        return $this->payload->encoded();
    }

    /**
     * Returns the Signature encoded.
     *
     * @return string
     */
    private function signatureEncoded(): string
    {
        return Base64::urlEncode($this->signature);
    }

    /**
     * Encode the Header and the Payload of the JSON Web Token.
     *
     * @return string
     */
    private function dataEncoded(): string
    {
        $headerEncoded = $this->headerEncoded();
        $payloadEncoded = $this->payloadEncoded();

        return "$headerEncoded.$payloadEncoded";
    }

    /**
     * Decodes a JSON Web Token.
     *
     * @param $token
     */
    public function decode($token): void
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

        // Decodes the Data of the JWT token.
        $this->header->decode($headerEncoded);
        $this->payload->decode($payloadEncoded);

        // Decodes the signature.
        $this->signature = Base64::urlDecode($signatureEncoded);
    }

    /**
     * Creates the JSON Web Token Signature.
     *
     * @todo Create a map between JWT Header and the signature_alg in openssl_sign
     * @todo If argument in another class.
     *
     * @return void
     */
    public function sign(): void
    {
        // Generates the signature and checks if it has failed.
        if (!\openssl_sign(
            $this->dataEncoded(),
            $this->signature,
            \openssl_pkey_get_private($this->asymmetricCryptography->privateKeyPath()),
            'sha256WithRSAEncryption')
        ) {
            // @todo throw Signature couldn't be signed
        }
    }

    /**
     * Check if the JSON Web Token was not changed.
     *
     * @todo Create a map between JWT Header and the signature_alg in openssl_sign
     * @todo If argument in another class.
     *
     * @return bool
     */
    public function verify(): bool
    {
        $result = \openssl_verify(
            $this->dataEncoded(),
            $this->signature,
            \openssl_pkey_get_public($this->asymmetricCryptography->publicKeyPath()),
            'sha256'
        );

        if ($result === -1)
        {
            // @todo throw Signature not valid
        }

        return \boolval($result);
    }

    /**
     * Returns the JSON Web Token encoded.
     *
     * @return string
     */
    public function encode(): string
    {
        return \implode(
            '.',
            [
                $this->headerEncoded(),
                $this->payloadEncoded(),
                $this->signatureEncoded()
            ]
        );
    }
}
