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
        return [];
    }

    /**
     * Return the id of the contact that is going to be deleted.
     * It comes in the last segment of the Uri.
     *
     * @todo validate if the id is positive.
     *
     * @return int
     */
    public function id(): int
    {
        return \last(\explode('/', $this->request->getRequestUri()));
    }
}
