<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Utilities\AsymmetricCryptography;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken\JwtHeader;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken\JwtPayload;
use NunoLopes\DomainContacts\Utilities\Base64;
use NunoLopes\DomainContacts\Utilities\Signatures\RsaSignature;

/**
 * Class JsonWebToken.
 *
 * @package NunoLopes\DomainContacts
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
     */
    public function __construct()
    {
        $this->header  = new JwtHeader();
        $this->payload = new JwtPayload();
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
     * @param string $token - JWT Token that is going to be decoded.
     *
     * @throws \InvalidArgumentException - If the token is not valid.
     *
     * @return void
     */
    public function decode(string $token): void
    {
        // Throw exceptions if token is invalid.
        if (\strlen(\trim($token)) === 0) {
            throw new \InvalidArgumentException('This token is empty');
        }
        if (\substr_count($token, '.') !== 2) {
            throw new \InvalidArgumentException(('This is not a Json Web Token.'));
        }

        // Deconstructs the token.
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
     * @return void
     */
    public function sign(RsaSignature $signature): void
    {
        $this->signature = $signature->sign(
            $this->dataEncoded(),
            $this->asymmetricCryptography->privateKeyPath()
        );
    }

    /**
     * Check if the JSON Web Token was not changed.
     *
     * @return bool
     */
    public function verify(RsaSignature $signature): bool
    {
        return $signature->verify(
            $this->dataEncoded(),
            $this->signature,
            $this->asymmetricCryptography->publicKeyPath()
        );
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
