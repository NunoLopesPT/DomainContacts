<?php
namespace NunoLopes\DomainContacts\Exceptions\Authentication;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class TokenRevokedException.
 *
 * @package NunoLopes\LaravelContactsAPI
 * @todo check status code
 */
class TokenRevokedException extends BaseException
{
    protected $message = "This token is revoked.";
}
