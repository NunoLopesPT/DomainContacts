<?php
namespace NunoLopes\DomainContacts\Exceptions\Contacts;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class ContactNotFound.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class ContactNotFound extends NotFoundException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be found.";
}
