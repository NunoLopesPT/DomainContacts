<?php
namespace NunoLopes\LaravelContactsAPI\Datatypes\AuthenticationToken\JsonWebToken;

use NunoLopes\LaravelContactsAPI\Utilities\Base64;

/**
 * Class JwtAbstractData.
 *
 * This class will help retrieving and building information for the JWT Header and JWT Payload.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
abstract class JwtData
{
    /**
     * Get a single attribute from the data.
     *
     * @param string $attribute - Name of the attribute.
     *
     * @throws \UnexpectedValueException - If no name was found in the attribute.
     *
     * @return string
     */
    public function get(string $attribute): string
    {
        if (!\property_exists($this, $attribute)) {
            throw new \UnexpectedValueException("'$attribute' is not supported in JWT Header.");
        }

        return $this->{$attribute};
    }

    /**
     * Get all attributes from the data.
     *
     * @return array
     */
    public function all(): array
    {
        $return = [];

        foreach (\get_object_vars($this) as $key => $value) {
            if ($value !== null) {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    /**
     * Decodes a retrieved piece of data from a string directly to the class attributes.
     *
     * @param string $dataEncoded - String containing the data encoded.
     *
     * @return void
     */
    public function decode(string $dataEncoded): void
    {
        $headerAttributes = \json_decode(Base64::urlDecode($dataEncoded), true);

        foreach ($headerAttributes as $attribute => $value) {
            if (\property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * Encodes the current data into Base64url.
     *
     * @return string
     */
    public function encoded(): string
    {
        return Base64::urlEncode(\json_encode($this->all()));
    }
}
