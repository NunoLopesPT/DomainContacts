<?php
namespace NunoLopes\DomainContacts\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for a Registration Request.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class RegisterUserRequest extends AbstractValidationRequest
{
    /**
     * The rules() method will return an array containing
     * all the rules to be validated by the Request object.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
