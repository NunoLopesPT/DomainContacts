<?php
namespace NunoLopes\DomainContacts\Exceptions\Entities\Contacts;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactHasNoIdException.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactHasNoIdException extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "This contact has no ID.";
}
