<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Contacts;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactNotUpdated.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class ContactNotUpdated extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Contact could not be updated.";
}
