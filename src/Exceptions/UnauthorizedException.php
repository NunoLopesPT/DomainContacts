<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions;

/**
 * Class UnauthorizedException
 *
 * @package NunoLopes\LaravelContactsAPI
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
