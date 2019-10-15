<?php
namespace NunoLopes\DomainContacts\Requests\Contacts;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for all UpdateContactRequest.
 *
 * @todo this request is similar to the create one, try to refactor this.
 *
 * @package NunoLopes\DomainContacts
 */
class UpdateContactRequest extends AbstractValidationRequest
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
            'first_name'   => 'required|min:3|max:255',
            'last_name'    => 'max:255',
            'email'        => 'nullable|regex:/\S+@\S+\.\S+/i|max:255',
            'phone_number' => 'nullable|string|max:255',
        ];
    }
}
