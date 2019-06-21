<?php
namespace NunoLopes\LaravelContactsAPI\Requests;

/**
 * This class will define the rules for all SaveContactRequests.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class SaveContactRequest extends AbstractValidationRequest
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
