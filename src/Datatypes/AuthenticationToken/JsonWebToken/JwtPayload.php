<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;

/**
 * Class JwtPayload.
 *
 * This will be a class using a Builder Pattern to help create a JWT Payload.
 *
 * @package NunoLopes\DomainContacts
 */
class JwtPayload extends JwtData
{
    /**
     * @var string $iss - Issuer Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.1
     */
    protected $iss = null;

    /**
     * @var string $sub - Subject Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.2
     */
    protected $sub = null;

    /**
     * @var array $aud - Audience Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.3
     */
    protected $aud = null;

    /**
     * @var int $exp - Expiration Time Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.4
     */
    protected $exp = null;

    /**
     * @var int $nbf - Not Before Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.5
     */
    protected $nbf = null;

    /**
     * @var int $iat - Issued At Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.6
     */
    protected $iat = null;

    /**
     * @var string $jti - JWT ID Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.7
     */
    protected $jti = null;

    /**
     * Setter for Issuer Claim.
     *
     * @param string $iss - Issuer Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.1
     *
     * @return self
     */
    public function issuer(string $iss): self
    {
        $this->iss = $iss;

        return $this;
    }

    /**
     * Getter function for the Issuer Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.1
     *
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->iss;
    }

    /**
     * Setter for Subject Claim.
     *
     * @param string $sub - Subject Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.2
     *
     * @return self
     */
    public function subject(string $sub): self
    {
        $this->sub = $sub;

        return $this;
    }

    /**
     * Getter function for the Subject Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.2
     *
     * @return string
     */
    public function getSubject(): string
    {
        return $this->sub;
    }

    /**
     * Setter for Audience Claim.
     *
     * @param array $aud - Audience Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.3
     *
     * @return self
     */
    public function audience(array $aud): self
    {
        $this->aud = $aud;

        return $this;
    }

    /**
     * Getter function for the Audience Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.3
     *
     * @return array
     */
    public function getAudience(): array
    {
        return $this->aud;
    }

    /**
     * Setter for Expiration Time Claim.
     *
     * @param int $exp - Expiration Time Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.4
     *
     * @return self
     */
    public function expiration(int $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    /**
     * Getter function for the Expiration Time Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.4
     *
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->exp;
    }

    /**
     * Setter for Not Before Claim.
     *
     * @param int $nbf - Not Before Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.5
     *
     * @return self
     */
    public function notBefore(int $nbf): self
    {
        $this->nbf = $nbf;

        return $this;
    }

    /**
     * Getter function for the Not Before Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.5
     *
     * @return int
     */
    public function getNotBefore(): int
    {
        return $this->nbf;
    }

    /**
     * Setter for Issued At Claim.
     *
     * @param int $iat - Issued At Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.6
     *
     * @return self
     */
    public function issuedAt(int $iat): self
    {
        $this->iat = $iat;

        return $this;
    }

    /**
     * Getter function for the Issued At Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.6
     *
     * @return int
     */
    public function getIssuedAt(): int
    {
        return $this->iat;
    }

    /**
     * Setter for JWT ID Claim.
     *
     * @param string $jti - JWT ID Claim.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.7
     *
     * @return self
     */
    public function id(string $jti): self
    {
        $this->jti = $jti;

        return $this;
    }

    /**
     * Getter function for the JWT ID Claim in JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1.7
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->jti;
    }

    /**
     * Encodes the JWT Payload if it fills all required attributes.
     *
     * @throws \UnexpectedValueException - If the JWT ID or the Expiration date is not set.
     *
     * @return string
     */
    public function encoded(): string
    {
        if (($this->jti === null) || ($this->exp === null)) {
            throw new \UnexpectedValueException('An ID and an Expiration Date should be set.');
        }

        return parent::encoded(); // TODO: Change the autogenerated stub
    }
}
