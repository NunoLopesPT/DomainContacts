<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\ContactsRepository;
use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotDeletedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotOwnedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotUpdatedException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;

/**
 * This Domain Service will be responsible for all Business Logic related with Contacts.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactsService
{
    /**
     * @var ContactsRepository - ContactsRepository Instance.
     */
    private $contactsRepository = null;

    /**
     * @var Authentication $auth - Authentication instance.
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
     * Display current authenticated user's contacts.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     *
     * @return array
     */
    public function listAllContactsOfAuthenticatedUser(): array
    {
        // Only logged-in users can have contacts.
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        return $this->contactsRepository->findByUserId($this->auth->id());
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  array  $attributes - Attributes of the new Contact.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws RequiredAttributeMissingException - If any required attribute is missing in the attributes.
     *
     * @return Contact
     */
    public function create(array $attributes): Contact
    {
        // Only logged-in users can create contacts.
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        // Insert the current logged in user id to the saving contact.
        $attributes['user_id'] = $this->auth->id();

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
     * @throws ContactNotOwnedException      - If the owner of the contact is different.
     *
     * @return Contact
     */
    public function edit(int $id): Contact
    {
        // Only logged-in users can create contacts.
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $this->auth->id()) {
            throw new ContactNotOwnedException();
        }

        return $contact;
    }

    /**
     * Update the specified Contact in storage and returns the entity
     * with the updated attributes.
     *
     * @param  int   $id         - ID of the Contact that is going to be updated.
     * @param  array $attributes - Attributes that are going to update.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws ContactNotFoundException      - If the contact to update was not found.
     * @throws ContactNotUpdatedException    - If the contact was not updated.
     * @throws ContactNotOwnedException      - If the owner of the contact is different.
     *
     * @return Contact
     */
    public function update(int $id, array $attributes): Contact
    {
        // Only logged-in users can create contacts.
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $this->auth->id()) {
            throw new ContactNotOwnedException();
        }

        // Validate the returned attributes.
        $contact->setAttributes($attributes);

        // Update the contact with the validated data,
        // and save it in the persistence layer.
        $this->contactsRepository->update($contact);

        // Returns the updated contact from the database.
        return $contact;
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     * @throws ContactNotFoundException      - If the contact to delete was not found.
     * @throws ContactNotDeletedException    - If the contact was not deleted.
     * @throws ContactNotOwnedException      - If the owner of the contact is different.
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        // Only logged-in users can create contacts.
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $this->auth->id()) {
            throw new ContactNotOwnedException();
        }

        // Returns success message if the contact was deleted.
        if (!$this->contactsRepository->destroy($id)) {
            throw new ContactNotDeletedException();
        };
    }
}
