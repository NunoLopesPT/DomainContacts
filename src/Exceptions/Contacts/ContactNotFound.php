<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions\Contacts;

use NunoLopes\LaravelContactsAPI\Exceptions\NotFoundException;

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
