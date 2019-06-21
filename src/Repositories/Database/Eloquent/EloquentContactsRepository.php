<?php
namespace NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent;

use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\Contact;

/**
 * Contact's Repository.
 */
class EloquentContactsRepository implements ContactsRepository
{
    /**
     * @var Contact $contact - Contact's Eloquent model instance.
     */
    protected $contacts = null;

    /**
     * Initializes the Contact's Repository instance.
     *
     * @param Contact $contact - Contact's Eloquent Model instance.
     */
    public function __construct(Contact $contact) {
        $this->contacts = $contact;
    }

    /**
     * @param array $attributes
     * @return int
     */
    public function create(array $attributes): int
    {
        $contact = $this->contacts->newQuery()->create($attributes);

        return $contact->id;
    }
}
