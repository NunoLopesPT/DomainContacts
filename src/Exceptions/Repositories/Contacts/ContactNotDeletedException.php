<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactNotDeletedException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactNotDeletedException extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be deleted.";
}
