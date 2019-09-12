<?php
namespace NunoLopes\DomainContacts\Entities;

use NunoLopes\DomainContacts\Exceptions\Contacts\RequiredAttributeMissing;

/**
 * Abstract class AbstractEntity..
 *
 * @package NunoLopes\DomainContacts\Entities
 */
abstract class AbstractEntity
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
     * @param $attributes
     */
    public function __construct($attributes)
    {
        $this->setAttributes($attributes);
    }

    /**
     * Sets the attributes of the contact.
     *
     * @param $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {

            $setter = 'set' . str_replace('_', '', \ucwords($key, '_'));

            if (\method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }

        // Check if all required attributes are not null.
        foreach (self::$required as $attribute) {
            if ($this->$attribute === null) {
                throw new RequiredAttributeMissing($attribute);
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
        return \get_object_vars($this);
    }

    /**
     * Returns the id of the Entity.
     *
     * @return int
     */
    public function id(): int
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
     * Transforms the Entity's attributes array to json.
     *
     * @return string
     */
    public function jsonSerialize(): string
    {
        return \json_encode($this->getAttributes());
    }
}