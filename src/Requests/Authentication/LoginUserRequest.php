<?php
namespace NunoLopes\LaravelContactsAPI\Requests\Authentication;

use NunoLopes\LaravelContactsAPI\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for a Login Request.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class LoginUserRequest extends AbstractValidationRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }
}
