<?php
namespace NunoLopes\DomainContacts\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for a Registration Request.
 *
 * @package NunoLopes\DomainContacts
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
     * Returns the email sent in the request.
     *
     * @return string
     */
    public function email(): string
    {
        return $this->request->get('email');
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
