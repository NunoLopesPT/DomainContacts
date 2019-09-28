<?php
namespace NunoLopes\DomainContacts\Exceptions;

/**
 * Class UnauthorizedException
 *
 * @package NunoLopes\DomainContacts
 */
class UnauthorizedException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "Unauthorized";

    /**
     * @inheritdoc
     */
    protected $code = 401;
}
