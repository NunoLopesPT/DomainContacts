<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions\Authentication;

use NunoLopes\LaravelContactsAPI\Exceptions\BaseException;

/**
 * Class PasswordMismatchException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class PasswordMismatchException extends BaseException
{
    protected $message = "Password does not match with this user.";
}
