<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions\Contacts;

use NunoLopes\LaravelContactsAPI\Exceptions\BaseException;

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
