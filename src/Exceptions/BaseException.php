<?php
namespace NunoLopes\DomainContacts\Exceptions;

/**
 * Abstract class BaseException.
 *
 * All Exceptions should extend this class.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class BaseException extends \RuntimeException
{
    /**
     * @var string $message - Exception Message.
     */
    protected $message = 'Unavailable exception message.';

    /**
     * @var int $code - HTTP Response code.
     */
    protected $code = 500;

    /**
     * BaseException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->message, $this->code);
    }
}
