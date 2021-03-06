<?php
namespace NunoLopes\DomainContacts\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for a Login Request.
 *
 * @package NunoLopes\DomainContacts
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
            'name'     => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Returns the name sent in the request.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->request->get('name');
    }

    /**
     * Returns the password sent in the request.
     *
     * @return string
     */
    public function password(): string
    {
        return $this->request->get('password');
    }
}
