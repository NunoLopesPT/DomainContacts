<?php
namespace NunoLopes\DomainContacts\Requests\Contacts;

/**
 * This class will define the rules for all UpdateContactRequest.
 *
 * @package NunoLopes\DomainContacts
 */
class UpdateContactRequest extends CreateContactRequest
{
    /**
     * Return the ID of the contact that is going to be updated.
     *
     * @todo replace this method to be similar to DeleteContactRequest.
     *
     * @return int
     */
    public function id(): int
    {
        return $this->request->get('id');
    }
}
