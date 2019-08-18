<?php

namespace NunoLopes\LaravelContactsAPI\Services;

use Illuminate\Database\Eloquent\Collection;
use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Contracts\Utilities\Authentication;
use NunoLopes\LaravelContactsAPI\Entities\Contact;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotFound;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotUpdated;
use NunoLopes\LaravelContactsAPI\Exceptions\ForbiddenException;
use NunoLopes\LaravelContactsAPI\Exceptions\UnauthorizedException;
use NunoLopes\LaravelContactsAPI\Requests\SaveContactRequest;

/**
 * This Domain Service will be responsible for all Business Logic related with Contacts.
 *
 * @package NunoLopes\LaravelContactsAPI\Services
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

        // Check if the contact is not null.
        if ($contact === null) {
            throw new ContactNotFound();
        }

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
        if (!$this->contactsRepository->update($id, $contact->getAttributes())) {

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
     *
     * @return bool
     */
    public function destroy(int $id): bool
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->userId() !== $this->auth->user()->id()) {
            throw new ForbiddenException();
        }

        // Returns success message if the contact was deleted.
        return $this->contactsRepository->destroy($id);
    }
}
