<?php

namespace NunoLopes\LaravelContactsAPI\Services;

use Illuminate\Support\Facades\Auth;
use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\Contact;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotDeleted;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotFound;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotUpdated;
use NunoLopes\LaravelContactsAPI\Exceptions\ForbiddenException;
use NunoLopes\LaravelContactsAPI\Exceptions\UnauthorizedException;
use NunoLopes\LaravelContactsAPI\Requests\SaveContactRequest;

/**
 * This Domain Service will be responsible for all Business Logic related with Contacts.
 *
 * @todo Add Middleware to check if the user is logged in.
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
     * ContactsServices constructor.
     *
     * @param ContactsRepository $contactsRepository - ContactsRepository Instance.
     */
    public function __construct(ContactsRepository $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    /**
     * Display the current user's contacts.
     *
     * @throws UnauthorizedException - If the user is a guest.
     *
     * @return array
     */
    public function index(): array
    {
        // Check if the user is logged in.
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        return $this->contactsRepository->findByUserId(Auth::id())->jsonSerialize();
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     *
     * @throws UnauthorizedException - If the user is a guest.
     *
     * @return int
     */
    public function store(SaveContactRequest $request)
    {
        // Check if the user is logged in.
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        // Insert the current logged in user id to the saving contact.
        $attributes = $request->validated();
        $attributes['user_id'] = Auth::id();

        // Returns the created contact ID so it can be redirected
        // to the edit view.
        return $this->contactsRepository->create($attributes);
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  int  $id - Contact that is going to be edited.
     *
     * @throws UnauthorizedException - If the user is a guest.
     * @throws ContactNotFound       - If the contact doesn't exist.
     * @throws ForbiddenException    - If the user doesn't own the contact.
     *
     * @return array
     */
    public function edit(int $id): array
    {
        // Check if the user is logged in.
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the contact is not null.
        if ($contact === null) {
            throw new ContactNotFound();
        }

        // Check if the user owns the contact.
        if ($contact->user_id !== Auth::id()) {
            throw new ForbiddenException();
        }

        return $contact->jsonSerialize();
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     * @param  Contact             $contact - Contact that is going to be updated.
     *
     * @throws UnauthorizedException - If the user is a guest.
     * @throws ContactNotUpdated     - If the contact was not updated.
     * @throws ForbiddenException    - If the user doesn't own the contact.
     *
     * @return array
     */
    public function update(SaveContactRequest $request, int $id): array
    {
        // Check if the user is logged in.
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->user_id !== Auth::id()) {
            throw new ForbiddenException();
        }

        // Update the contact with the validated data,
        // and save it in the persistence layer.
        if ($contact->fill($request->validated())->save()) {

            // Returns the updated contact.
            return $contact->jsonSerialize();
        }

        // If we reach the end of this function, the contact was not
        // updated so we throw an exception.
        throw new ContactNotUpdated();
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @throws UnauthorizedException - If the user is a guest.
     * @throws ForbiddenException    - If the user doesn't own the contact that wants to delete.
     * @throws ContactNotDeleted     - If the contact couldn't be deleted.
     *
     * @return string
     */
    public function destroy(int $id): string
    {
        // Check if the user is logged in.
        if (Auth::guest()) {
            throw new UnauthorizedException();
        }

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsRepository->get($id);

        // Check if the user owns the contact.
        if ($contact->user_id !== Auth::id()) {
            throw new ForbiddenException();
        }

        // Returns success message if the contact was deleted.
        if ($this->contactsRepository->destroy($id)) {
            return "Contact Deleted.";
        }

        // If we reach the end of this function, the contact was not
        // deleted so we throw an exception.
        throw new ContactNotDeleted();
    }
}
