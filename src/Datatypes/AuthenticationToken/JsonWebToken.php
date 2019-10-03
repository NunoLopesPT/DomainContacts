<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Utilities\AsymmetricCryptography;
use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken\JwtHeader;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken\JwtPayload;
use NunoLopes\DomainContacts\Utilities\Base64;

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
     * Returns the JWT Payload instance.
     *
     * @return JwtPayload
     */
    public function payload(): JwtPayload
    {
        return $this->payload;
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
     * Returns the Header and the Payload encoded separated by a dot.
     *
     * @return string
     */
    private function dataEncoded(): string
    {
        return $this->header->encoded() . '.' . $this->payload->encoded();
    }

    /**
     * Creates the JSON Web Token Signature.
     *
     * @param RsaSignature           $signature - Signature Instance.
     * @param AsymmetricCryptography $crypt     - AsymmetricCryptography instance.
     *
     * @return void
     */
    public function sign(RsaSignature $signature, AsymmetricCryptography $crypt): void
    {
        // Set the algorithm in the header.
        $this->header->algorithm($signature->code());

        // Sign the JWT's payload.
        $this->signature = $signature->sign(
            $this->dataEncoded(),
            $crypt->privateKey()
        );
    }

    /**
     * Check if the JSON Web Token was not changed.
     *
     * @param RsaSignature           $signature - Signature Instance.
     * @param AsymmetricCryptography $crypt     - AsymmetricCryptography instance.
     *
     * @throws \UnexpectedValueException - If the Algorithm code is different from the given Signature.
     *
     * @return bool
     */
    public function verify(RsaSignature $signature, AsymmetricCryptography $crypt): bool
    {
        if ($signature->code() !== $this->header->getAlgorithm()) {
            throw new \UnexpectedValueException('The signature does not match with the JWT.');
        }

        return $signature->verify(
            $this->dataEncoded(),
            $this->signature,
            $crypt->publicKey()
        );
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
     * Returns the JSON Web Token encoded.
     *
     * @return string
     */
    public function encode(): string
    {
        return $this->dataEncoded() . '.' . $this->signatureEncoded();
    }
}
