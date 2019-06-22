<?php
namespace NunoLopes\LaravelContactsAPI\Contracts\Database;

use Illuminate\Database\Eloquent\Collection;
use NunoLopes\LaravelContactsAPI\Eloquent\Contact;

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
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Retrieves a single Contact by its ID.
     *
     * @param int $id - ID of the Contact.
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
}
