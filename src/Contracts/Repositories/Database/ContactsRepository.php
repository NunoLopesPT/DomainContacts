<?php
namespace NunoLopes\DomainContacts\Contracts\Repositories\Database;

use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactAlreadyCreatedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotUpdatedException;

/**
 * Contacts Repository Contract.
 *
 * This contract will allow other repositories to be used with a Strategy Pattern, and
 * making the code more SOLID (Dependency inversion principle).
 *
 * All Contacts Repository will implement this Contract.
 */
interface ContactsRepository
{
    /**
     * Will create a new Contact in the persistence layer, returning
     * the created Entity with an ID.
     *
     * @param Contact $contact - Contact Entity that is going to be created.
     *
     * @throws ContactAlreadyCreatedException - If the Contact already exists.
     *
     * @return Contact
     */
    public function create(Contact $contact): Contact;

    /**
     * Retrieve all contacts.
     *
     * @param  int $id - ID of the user to retrieve contacts.
     *
     * @return array
     */
    public function findByUserId(int $id): array;

    /**
     * Retrieves a single Contact by its ID.
     *
     * @param int $id - ID of the Contact.
     *
     * @throws ContactNotFoundException - If the contact was not found.
     *
     * @return Contact
     */
    public function get(int $id): Contact;

    /**
     * Destroys a single Contact and returns its success.
     *
     * @param int $id - ID of the Contact that will be deleted.
     *
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Updates a Contact with its attributes.
     *
     * @param Contact $contact - Contact that is going to be updated.
     *
     * @throws \UnexpectedValueException - If the Contact has no ID.
     * @throws ContactNotUpdatedException - If the Contact was not updated.
     *
     * @return Contact
     */
    public function update(Contact $contact): Contact;
}
