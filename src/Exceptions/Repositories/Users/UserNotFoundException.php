<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Users;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class UserNotFoundException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class UserNotFoundException extends NotFoundException
{
    /**
     * @inheritdoc
     */
    protected $message = "This user was not found.";
}
