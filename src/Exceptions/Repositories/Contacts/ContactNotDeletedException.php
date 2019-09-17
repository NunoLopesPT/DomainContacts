<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactNotDeleted.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class ContactNotDeleted extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be deleted.";
}
