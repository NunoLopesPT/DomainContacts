<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions;

/**
 * Class ForbiddenException.
 *
 * @package NunoLopes\LaravelContactsAPI
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
