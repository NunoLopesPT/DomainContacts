<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class ContactNotFoundException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactNotFoundException extends NotFoundException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be found.";
}
