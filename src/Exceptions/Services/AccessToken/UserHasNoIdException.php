<?php
namespace NunoLopes\DomainContacts\Exceptions\Services\AccessToken;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class UserHasNoIdException.
 *
 * @package NunoLopes\DomainContacts
 */
class UserHasNoIdException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "The user required for the AccessToken doesn't have an ID.";
}
