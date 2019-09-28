<?php
namespace NunoLopes\DomainContacts\Entities;

use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;

/**
 * Abstract class AbstractEntity..
 *
 * @package NunoLopes\DomainContacts\Entities
 */
abstract class AbstractEntity implements \JsonSerializable
{
    /**
     * @var array $required - Array of required attribute names where the value can't be null.
     */
    protected static $required = [];

    /**
     * Id of the entity.
     *
     * @var int
     */
    protected $id = null;

    /**
     * Contact constructor.
     *
     * @param array $attributes - Attributes to set on the Entity.
     *
     * @throws RequiredAttributeMissingException - If there are required attributes missing.
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes($attributes);
    }

    /**
     * Sets the attributes of the contact.
     *
     * @param array $attributes - Attributes to set on the Entity.
     *
     * @throws RequiredAttributeMissingException - If there are required attributes missing.
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {

            // Search for the setter method.
            $setter = 'set' . str_replace('_', '', \ucwords($key, '_'));

            // If it exists, call it.
            if (\method_exists($this, $setter)) {
                $this->{$setter}($value);
            } else {
                throw new \InvalidArgumentException("This attribute '$key' doesn't exists.");
            }
        }

        // Check if all required attributes are not null.
        foreach (static::$required as $attribute) {
            if ($this->$attribute === null) {
                throw new RequiredAttributeMissingException($attribute);
            }
        }
    }

    /**
     * Returns the Entity's Attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        // Get all attributes using all the getters.
        $attributes = [];
        foreach(\array_keys(\get_object_vars($this)) as $attribute) {

            // Construct the getter name.
            $getter = \lcfirst(\str_replace('_', '', \ucwords($attribute, '_')));

            // Get the attribute's value from the getter.
            $attributes[$attribute] = $this->{$getter}();
        }

        return $attributes;
    }

    /**
     * Returns the id of the Entity.
     *
     * @return int|NULL
     */
    public function id(): ?int
    {
        return $this->id;
    }

    /**
     * Check if there is an ID in the entity.
     *
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== null;
    }

    /**
     * Set the id of the Entity.
     *
     * @param int $id - Sets the id of the Entity.
     *
     * @throws \InvalidArgumentException - If the id is not a positive number.
     *
     * @return void
     */
    protected function setId(int $id): void
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('The id should be a positive number.');
        }

        $this->id = $id;
    }

    /**
     * Returns the attributes in an array to be JsonSerialized.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getAttributes();
    }
}