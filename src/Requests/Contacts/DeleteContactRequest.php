<?php
namespace NunoLopes\DomainContacts\Requests\Contacts;

use NunoLopes\DomainContacts\Requests\AbstractValidationRequest;

/**
 * This class will define the rules for all DeleteContactRequest.
 *
 * @package NunoLopes\DomainContacts
 */
class DeleteContactRequest extends AbstractValidationRequest
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
            'id' => 'required|integer|min:1'
        ];
    }
}
