<?php
namespace NunoLopes\DomainContacts\Entities;

use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;

/**
 * Abstract class AbstractEntity.
 *
 * This class will add extra functionality of having an
 * initial state, and check the changed attributes.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class AbstractEntityState extends AbstractEntity
{
    /**
     * @var array $initialState - Initial state of the Entity.
     */
    private $initialState = null;

    /**
     * Contact constructor.
     *
     * @throws RequiredAttributeMissingException - If there are required attributes missing.
     *
     * @param $attributes
     */
    public function __construct($attributes)
    {
        // Calls parent constructor.
        parent::__construct($attributes);

        // Since the initialState is private, it won't be retrieved from the
        // get_object_vars in the getAttributes because it is not visible there.
        $this->initialState = $this->getAttributes();
    }

    /**
     * Get the attributes that are different from the initial ones.
     *
     * @return array
     */
    public function getDirtyAttributes(): array
    {
        $return = [];
        foreach ($this->getAttributes() as $attribute => $value) {
            if ($value !== $this->initialState[$attribute]) {
                $return[$attribute] = $value;
            }
        }

        return $return;
    }
}
