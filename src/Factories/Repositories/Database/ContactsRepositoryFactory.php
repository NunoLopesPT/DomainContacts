<?php
namespace NunoLopes\DomainContacts\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Contracts\Database\ContactsRepository;
use NunoLopes\DomainContacts\Eloquent\Contact;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentContactsRepository;

/**
 * Class ContactsRepositoryFactory.
 *
 * This class will be used to create an ContactsRepository instance.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactsRepositoryFactory
{
    /**
     * @var ContactsRepository $contactsRepository - Singleton instance of ContactsRepository.
     */
    private static $contactsRepository = null;

    /**
     * Create a new ContactsRepository instance.
     *
     * @return ContactsRepository
     */
    private static function create(): ContactsRepository
    {
        return new EloquentContactsRepository(
            new Contact()
        );
    }

    /**
     * Get a new ContactsRepository instance if not found or
     * return the one already created (Singleton).
     *
     * @return ContactsRepository
     */
    public static function get(): ContactsRepository
    {
        if (self::$contactsRepository === null) {
            self::$contactsRepository = self::create();
        }

        return self::$contactsRepository;
    }
}
