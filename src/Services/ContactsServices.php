<?php

namespace NunoLopes\LaravelContactsAPI\Services;

use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\Contact;
use NunoLopes\LaravelContactsAPI\Requests\SaveContactRequest;

/**
 * This Domain Service will be responsible for all Business Logic related with Contacts.
 *
 * @package NunoLopes\LaravelContactsAPI\Services
 */
class ContactsServices
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
     * @return array
     */
    public function index()
    {
        return ['contacts' => Contact::all()];
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     *
     * @return array
     */
    public function store(SaveContactRequest $request)
    {
        // Creates the contact for the current user with the validated data.
        $id = $this->contactsRepository->create($request->validated());

        // Redirects to the edit view of the created contact
        // with a success message.
        return [
            'redirect' => "/contacts/{$id}/edit",
            'success'  => 'Contact was created with success.'
        ];
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  Contact  $contact - Contact that is going to be edited.
     *
     * @return array
     */
    public function edit(Contact $contact)
    {
        // Check if the user can see/edit the contact.
        //$this->authorize('save', $contact);

        // Loads the edit view with the given contact.
        return ['contact' => $contact];
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     * @param  Contact             $contact - Contact that is going to be updated.
     *
     * @return array
     */
    public function update(SaveContactRequest $request, Contact $contact)
    {
        // Check if the user can update the contact.
        //$this->authorize('save', $contact);

        // Update the contact with the validated data,
        // and save it in the persistence layer.
        $contact->fill($request->validated())->save();

        // Redirects to the same view with a success message.
        return [
            'contact' => $contact,
            'success' => 'Contact was updated with success.'
        ];
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param  Contact  $contact - Contact that is going to be destroyed.
     *
     * @return array
     */
    public function destroy(Contact $contact)
    {
        // Check if the user can delete the contact.
        //$this->authorize('save', $contact);

        // Delete the contact.
        $contact->delete();

        // Redirects to the same view with a success message.
        return ['success' => 'Contact was deleted with success.'];
    }
}
