<?php
namespace NunoLopes\DomainContacts\Exceptions\Services\Authentication;

use NunoLopes\DomainContacts\Exceptions\UnauthorizedException;

/**
 * Class UserNotAuthenticatedException.
 *
 * @package NunoLopes\DomainContacts
 */
class UserNotAuthenticatedException extends UnauthorizedException
{
    /**
     * @inheritdoc
     */
    protected $message = "There is no user authenticated.";
}
