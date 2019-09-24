<?php
namespace NunoLopes\DomainContacts\Exceptions\Services\Authentication;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class UserNotAuthenticatedException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class UserNotAuthenticatedException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "There is no user authenticated.";
}
