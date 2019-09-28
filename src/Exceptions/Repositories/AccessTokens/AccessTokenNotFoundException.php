<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class AccessTokenNotFound.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenNotFoundException extends NotFoundException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "AccessToken could not be found.";
}
