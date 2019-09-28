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
    protected $cty = null;

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
     * Setter for the Content Type in the JWT Token.
     *
     * @param string $cty - Content Type.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-5.2
     *
     * @return JwtHeader
     */
    public function type(string $cty): self
    {
        $this->cty = $cty;

        return $this;
    }
}