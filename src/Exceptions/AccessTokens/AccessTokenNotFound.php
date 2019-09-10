<?php
namespace NunoLopes\DomainContacts\Exceptions\AccessTokens;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class AccessTokenNotFound.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class AccessTokenNotFound extends NotFoundException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "AccessToken could not be found.";
}
