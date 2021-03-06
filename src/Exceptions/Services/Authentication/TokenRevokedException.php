<?php
namespace NunoLopes\DomainContacts\Exceptions\Services\Authentication;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class TokenRevokedException.
 *
 * @package NunoLopes\DomainContacts
 * @todo check status code
 */
class TokenRevokedException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "This token is revoked.";
}
