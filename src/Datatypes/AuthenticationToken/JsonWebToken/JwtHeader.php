<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;

/**
 * Class JwtHeader.
 *
 * This will be a class using a Builder Pattern to help create a JWT Header.
 *
 * @package NunoLopes\DomainContacts
 */
class JwtHeader extends JwtData
{
    /**
     * @var string $alg - Algorithm used in the JWT Token.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-5.1
     */
    protected $alg = null;

    /**
     * @var string $cty - Content type header.
     *
     * https://tools.ietf.org/html/rfc7519#section-5.2
     */
    protected $cty = 'JWT';

    /**
     * Setter for Algorithm in the JWT Token (Usually is 'JWT').
     *
     * @param string $alg - Algorithm used.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-5.1
     *
     * @return JwtHeader
     */
    public function algorithm(string $alg): self
    {
        $this->alg = $alg;

        return $this;
    }

    /**
     * Encodes the JWT Header if it fills all required attributes.
     *
     * @throws \UnexpectedValueException - If the Algorithm is not set.
     *
     * @return string
     */
    public function encoded(): string
    {
        if ($this->alg === null) {
            throw new \UnexpectedValueException('Algorithm is not set.');
        }

        return parent::encoded();
    }
}
