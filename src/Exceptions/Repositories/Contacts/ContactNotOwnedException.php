<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\ForbiddenException;

/**
 * Class ContactNotOwnedException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactNotOwnedException extends ForbiddenException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "You don't have access to this contact.";
}
