<?php
namespace NunoLopes\DomainContacts\Exceptions\Entities;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class RequiredAttributeMissingException.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class RequiredAttributeMissingException extends BaseException
{
    /**
     * @var string $message - Exception message.
     */
    protected $message = "Required attribute (%s) is missing.";

    /**
     * RequiredAttributeMissing constructor.
     *
     * @param string $attribute - Name of the attribute that is missing.
     */
    public function __construct(string $attribute)
    {
        $this->message = \sprintf($this->message, $attribute);

        parent::__construct();
    }
}
