<?php
namespace NunoLopes\DomainContacts\Exceptions\Services\Authentication;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class PasswordMismatchException.
 *
 * @package NunoLopes\DomainContacts
 */
class PasswordMismatchException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "Password does not match with this user.";
}
