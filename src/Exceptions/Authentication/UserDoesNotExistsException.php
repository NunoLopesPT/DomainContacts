<?php
namespace NunoLopes\DomainContacts\Exceptions\Authentication;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class UserDoesNotExistsException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class UserDoesNotExistsException extends NotFoundException
{
    /**
     * @inheritdoc
     */
    protected $message = "This user was not found.";
}
