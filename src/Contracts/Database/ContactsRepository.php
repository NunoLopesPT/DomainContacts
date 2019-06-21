<?php

namespace NunoLopes\LaravelContactsAPI\Contracts\Database;

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
}
