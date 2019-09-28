<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class ContactAlreadyCreatedException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactAlreadyCreatedException extends NotFoundException
{
    /**
     * @inheritdoc
     */
    protected $message = "This contact is already created.";
}
