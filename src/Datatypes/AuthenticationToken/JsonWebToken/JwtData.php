<?php
namespace NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;

use NunoLopes\DomainContacts\Utilities\Base64;

/**
 * Class JwtAbstractData.
 *
 * This class will help retrieving and building information for the JWT Header and JWT Payload.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class JwtData
{
    /**
     * Get all attributes from the data.
     *
     * @return array
     */
    private function all(): array
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
