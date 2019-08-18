<?php
namespace NunoLopes\DomainContacts\Contracts\Database;

use NunoLopes\DomainContacts\Entities\Contact;

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
     * Will create a new Contact in the persistence layer, returning its ID.
     *
     * @param array $attributes - Attributes of the Contact that will be created.
     *
     * @return int
     */
    public function create(array $attributes): int;

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
     * @return Contact
     */
    public function get(int $id): ?Contact;

    /**
     * Destroys a single Contact and returns its success.
     *
     * @param int $id - ID of the Contact that will be deleted.
     *
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Updates a record with following id.
     *
     * @todo Currently this $attributes also have the not dirty attributes
     *
     * @param int   $id         - ID of the Contact that is going to be updated.
     * @param array $attributes - New attributes of the Contact.
     *
     * @return bool
     */
    public function update(int $id, array $attributes): bool;
}
