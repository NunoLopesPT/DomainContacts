<?php
namespace NunoLopes\DomainContacts\Exceptions;

/**
 * Class ForbiddenException.
 *
 * @package NunoLopes\DomainContacts
 */
class ForbiddenException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $code = 403;

    /**
     * @inheritdoc
     */
    protected $message = "Forbidden Action.";
}
