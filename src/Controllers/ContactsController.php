<?php

namespace NunoLopes\LaravelContactsAPI\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use NunoLopes\LaravelContactsAPI\Entities\User;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotDeleted;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotFound;
use NunoLopes\LaravelContactsAPI\Exceptions\Contacts\ContactNotUpdated;
use NunoLopes\LaravelContactsAPI\Exceptions\ForbiddenException;
use NunoLopes\LaravelContactsAPI\Exceptions\UnauthorizedException;
use NunoLopes\LaravelContactsAPI\Requests\SaveContactRequest;
use NunoLopes\LaravelContactsAPI\Services\ContactsService;

/**
 * This Controller is part of the Application Layer.
 *
 * @todo Add Middleware to check if the user is logged in.
 */
class ContactsController
{
    /**
     * @var ContactsService - ContactsService Instance.
     */
    private $contactsService = null;

    /**
     * ContactsServices constructor.
     *
     * @param ContactsService $contactsService - ContactsService Instance.
     */
    public function __construct(ContactsService $contactsService)
    {
        $this->contactsService = $contactsService;
    }

    /**
     * Display the current user's contacts.
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Get all contacts.
        $contacts = $this->contactsService->listAllContactsFromUser();

        return response()
            ->view('laravel-contacts-api::contacts.index', [ 'contacts' => $contacts ], 200);
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
        return $this->contactsService->create($request->validated());
    }

    /**
     * Show the data for editing the specified Contact.
     *
     * @param  int  $id - ID of the Contact that is going to be edited.
     *
     * @throws ContactNotFound    - If the contact doesn't exist.
     * @throws ForbiddenException - If the user doesn't own the contact.
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        $user = new User(Auth::user()->getAttributes());

        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsService->edit($id, $user);

        return response()
            ->view('laravel-contacts-api::contacts.edit', [ 'contact' => $contact ], 200);
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     * @param  int                 $int     - ID of the contact that is going to be updated.
     *
     * @throws UnauthorizedException - If the user is a guest.
     * @throws ContactNotUpdated     - If the contact was not updated.
     * @throws ForbiddenException    - If the user doesn't own the contact.
     *
     * @return Response
     */
    public function update(SaveContactRequest $request, int $id): Response
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        $contact = $this->contactsService->update($id, $request->validated());

        return response()
            ->view('laravel-contacts-api::contacts.edit', [ 'contact' => $contact ], 200);
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @throws ForbiddenException    - If the user doesn't own the contact that wants to delete.
     * @throws ContactNotDeleted     - If the contact couldn't be deleted.
     *
     * @return string
     */
    public function destroy(int $id): string
    {
        // Retrieve the contact from the database to check
        // if its owner matches the logged in user.
        if ($this->contactsService->destroy($id)) {
            return response(null, 204);
        } else {
            // If we reach the end of this function, the contact was not
            // deleted so we throw an exception.
            throw new ContactNotDeleted();
        }
    }
}