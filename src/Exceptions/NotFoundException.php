<?php
namespace NunoLopes\DomainContacts\Exceptions;

/**
 * Class NotFoundException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class NotFoundException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $code = 404;

    /**
     * @inheritdoc
     */
    protected $message = "Not Found.";
}
