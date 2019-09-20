<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactNotUpdatedException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactNotUpdatedException extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be updated.";
}
