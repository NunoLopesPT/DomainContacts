<?php
namespace NunoLopes\DomainContacts\Exceptions;

/**
 * Class NotFoundException.
 *
 * @package NunoLopes\DomainContacts
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
