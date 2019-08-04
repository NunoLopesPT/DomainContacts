<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions\Contacts;

use NunoLopes\LaravelContactsAPI\Exceptions\BaseException;

/**
 * Class ContactNotDeleted.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class ContactNotDeleted extends BaseException
{
    protected $message = "Contact could not be deleted.";
}
