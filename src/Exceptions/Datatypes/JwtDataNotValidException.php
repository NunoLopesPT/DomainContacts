<?php
namespace NunoLopes\DomainContacts\Exceptions\Datatypes;

use NunoLopes\DomainContacts\Exceptions\BaseException;

/**
 * Class ContactAlreadyCreatedException.
 *
 * @todo check Status code.
 *
 * @package NunoLopes\DomainContacts
 */
class JwtDataNotValidException extends BaseException
{
    /**
     * @inheritdoc
     */
    protected $message = "JSON Web Token Data is not valid.";
}
