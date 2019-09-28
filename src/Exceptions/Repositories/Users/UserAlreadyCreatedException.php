<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\Users;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class UserAlreadyCreatedException.
 *
 * @package NunoLopes\DomainContacts
 */
class UserAlreadyCreatedException extends NotFoundException
{
    /**
     * @inheritdoc
     */
    protected $message = "This user is already created.";
}
