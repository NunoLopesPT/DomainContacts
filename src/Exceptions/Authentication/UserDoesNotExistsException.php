<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions\Authentication;

use NunoLopes\LaravelContactsAPI\Exceptions\NotFoundException;

/**
 * Class UserDoesNotExistsException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class UserDoesNotExistsException extends NotFoundException
{
    protected $message = "This user was not found.";
}
