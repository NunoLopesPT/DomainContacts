<?php
namespace NunoLopes\LaravelContactsAPI\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class BaseException extends \RuntimeException implements HttpExceptionInterface
{
    /**
     * @var string $message - Exception Message.
     */
    protected $message = 'Unavailable exception message.';

    /**
     * @var int $code - HTTP Responde code.
     */
    protected $code = 500;

    /**
     * BaseException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->message, $this->code);
    }

    /**
     * @inheritdoc
     */
    public function getStatusCode()
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return [];
    }
}
