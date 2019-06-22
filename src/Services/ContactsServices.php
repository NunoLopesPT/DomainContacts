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
        return $this->contactsRepository->all()->jsonSerialize();
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  SaveContactRequest  $request - Request instance with the validated data.
     *
     * @return int
     */
    public function store(SaveContactRequest $request)
    {
        return $this->contactsRepository->create($request->validated());
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  int  $id - Contact that is going to be edited.
     *
     * @return array
     */
    public function edit(int $id): array
    {
        return $this->contactsRepository->get($id)->jsonSerialize();
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
     * @param  int  $id - Id of the Contact that is going to be destroyed.
     *
     * @return string
     */
    public function destroy(int $id): string
    {
        return ($this->contactsRepository->destroy($id) ? '1' : '0');
    }
}
