<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class ContactNotFound.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class ContactNotFoundException extends NotFoundException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be found.";
}
