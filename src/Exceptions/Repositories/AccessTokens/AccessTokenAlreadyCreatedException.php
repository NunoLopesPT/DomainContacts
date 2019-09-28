<?php
namespace NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens;

use NunoLopes\DomainContacts\Exceptions\NotFoundException;

/**
 * Class AccessTokenAlreadyCreatedException.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenAlreadyCreatedException extends NotFoundException
{
    /**
     * @inheritdoc
     */
    protected $message = "This AccessToken is already created.";
}
