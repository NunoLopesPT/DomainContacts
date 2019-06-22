<?php
namespace NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent;

use Illuminate\Database\Eloquent\Collection;
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
     * @inheritdoc
     */
    public function get(int $id): Contact
    {
        return $this->contacts
                    ->newQuery()
                    ->whereKey($id)
                    ->first();
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes): int
    {
        $contact = $this->contacts
                        ->newQuery()
                        ->create($attributes);

        return $contact->id;
    }

    /**
     * @inheritdoc
     */
    public function all(): Collection
    {
        return $this->contacts
                    ->newQuery()
                    ->get();
    }

    /**
     * @inheritdoc
     */
    public function destroy(int $id): bool
    {
        return $this->contacts
                    ->newQuery()
                    ->whereKey($id)
                    ->delete();
    }
}
