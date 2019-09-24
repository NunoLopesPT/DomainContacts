<?php

namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Database\ContactsRepository;
use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\ForbiddenException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotDeletedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotUpdatedException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;

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
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     *
     * @return array
     */
    public function listAllContactsOfAuthenticatedUser(): array
    {
        // Retrieve the logged-in user.
        $user = $this->auth->user();

        // Only logged-in users can have contacts.
        if ($user === null) {
            throw new UserNotAuthenticatedException();
        }

        return $this->contactsRepository->findByUserId($user->id());
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  array  $attributes - Request instance with the validated data.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     *
     * @return int
     */
    public function create(array $attributes)
    {
        // Retrieve the logged-in user.
        $user = $this->auth->user();

        // Only logged-in users can create contacts.
        if ($user === null) {
            throw new UserNotAuthenticatedException();
        }

        // Insert the current logged in user id to the saving contact.
        $attributes['user_id'] = $user->id();

        // Returns the created contact ID so it can be redirected
        // to the edit view.
        return $this->contactsRepository->create(new Contact($attributes));
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  int  $id - Contact that is going to be edited.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws ContactNotFoundException      - If the contact doesn't exist.
     * @throws ForbiddenException            - If the user doesn't own the contact.
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

        // Only logged-in users can create contacts.
        if ($user === null) {
            throw new UserNotAuthenticatedException();
        }

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
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws ContactNotFoundException      - If the contact to edit was not found.
     * @throws ContactNotUpdatedException    - If the contact was not updated.
     * @throws ForbiddenException            - If the user doesn't own the contact.
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

        // Only logged-in users can create contacts.
        if ($user === null) {
            throw new UserNotAuthenticatedException();
        }

        // Validate the returned attributes.
        $contact->setAttributes($attributes);

        // Update the contact with the validated data,
        // and save it in the persistence layer.
        if (!$this->contactsRepository->update($contact)) {

            // If we reach the end of this function, the contact was not
            // updated so we throw an exception.
            throw new ContactNotUpdatedException();
        }

        // Returns the updated contact.
        return $contact;
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws ContactNotFoundException      - If the contact to delete was not found.
     * @throws ForbiddenException            - If the user doesn't own the contact that wants to delete.
     * @throws ContactNotDeletedException    - If the contact was not deleted.
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        // Retrieve the logged user.
        $user = $this->auth->user();

        // Only logged-in users can create contacts.
        if ($user === null) {
            throw new UserNotAuthenticatedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $user->id()) {
            throw new ForbiddenException();
        }

        // Returns success message if the contact was deleted.
        if (!$this->contactsRepository->destroy($id)) {
            throw new ContactNotDeletedException();
        };
    }
}
