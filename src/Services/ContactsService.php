<?php

namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Database\ContactsRepository;
use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Contacts\ContactNotDeleted;
use NunoLopes\DomainContacts\Exceptions\Contacts\ContactNotFound;
use NunoLopes\DomainContacts\Exceptions\Contacts\ContactNotUpdated;
use NunoLopes\DomainContacts\Exceptions\ForbiddenException;

/**
 * This Domain Service will be responsible for all Business Logic related with Contacts.
 *
 * @package NunoLopes\DomainContacts\Services
 */
class ContactsService
{
    /**
     * @var ContactsRepository - ContactsRepository Instance.
     */
    private $contactsRepository = null;

    /**
     * @var Authentication $auth - Authentication Manager instance.
     */
    private $auth = null;

    /**
     * ContactsServices constructor.
     *
     * @param ContactsRepository $contactsRepository - ContactsRepository Instance.
     * @param Authentication     $auth               - Authentication Instance.
     */
    public function __construct(ContactsRepository $contactsRepository, Authentication $auth)
    {
        $this->contactsRepository = $contactsRepository;
        $this->auth               = $auth;
    }

    /**
     * Display the current user's contacts.
     *
     * @return array
     */
    public function listAllContactsOfAuthenticatedUser(): array
    {
        // Retrieve the logged user.
        $user = $this->auth->user();

        return $this->contactsRepository->findByUserId($user->id());
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  array  $attributes - Request instance with the validated data.
     *
     * @return int
     */
    public function create(array $attributes)
    {
        // Insert the current logged in user id to the saving contact.
        $attributes['user_id'] = $this->auth->user()->id();

        // Returns the created contact ID so it can be redirected
        // to the edit view.
        return $this->contactsRepository->create($attributes);
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  int  $id - Contact that is going to be edited.
     *
     * @throws ContactNotFound    - If the contact doesn't exist.
     * @throws ForbiddenException - If the user doesn't own the contact.
     *
     * @return array
     */
    public function edit(int $id): Contact
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Retrieve the logged user.
        $user = $this->auth->user();

        // Check if the user owns the contact.
        if ($contact->userId() !== $user->id()) {
            throw new ForbiddenException();
        }

        return $contact;
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  int  $id - ID of the Contact that is going to be updated.
     * @param  array $attributes - Attributes that are going to update.
     *
     *
     * @throws ContactNotUpdated  - If the contact was not updated.
     * @throws ForbiddenException - If the user doesn't own the contact.
     *
     * @return Contact
     */
    public function update(int $id, array $attributes): Contact
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Retrieve the logged user.
        $user = $this->auth->user();

        // Check if the user owns the contact.
        if ($contact->userId() !== $user->id()) {
            throw new ForbiddenException();
        }

        // Validate the returned attributes.
        $contact->setAttributes($attributes);

        // Update the contact with the validated data,
        // and save it in the persistence layer.
        if (!$this->contactsRepository->update($contact)) {

            // If we reach the end of this function, the contact was not
            // updated so we throw an exception.
            throw new ContactNotUpdated();
        }

        // Returns the updated contact.
        return $contact;
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @throws ForbiddenException - If the user doesn't own the contact that wants to delete.
     * @throws ContactNotDeleted  - If the contact was not deleted.
     *
     * @return bool
     */
    public function destroy(int $id): void
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $this->auth->user()->id()) {
            throw new ForbiddenException();
        }

        // Returns success message if the contact was deleted.
        if ($this->contactsRepository->destroy($id)) {
            throw new ContactNotDeleted();
        };
    }
}
