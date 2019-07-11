<?php
namespace NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent;

use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\Contact as Model;
use NunoLopes\LaravelContactsAPI\Entities\Contact;

/**
 * Contact's Repository.
 */
class EloquentContactsRepository implements ContactsRepository
{
    /**
     * @var Model $contact - Contact's Eloquent model instance.
     */
    protected $contacts = null;

    /**
     * Initializes the Contact's Repository instance.
     *
     * @param Model $contact - Contact's Eloquent Model instance.
     */
    public function __construct(Model $contact) {
        $this->contacts = $contact;
    }

    /**
     * @inheritdoc
     */
    public function get(int $id): ?Contact
    {
        if ($id < 0) {
            // @todo Exception
        }

        $contact = $this->contacts
                        ->newQuery()
                        ->whereKey($id)
                        ->first();

        return new Contact($contact->getAttributes());
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
    public function findByUserId(int $id): array
    {
        return $this->contacts
                    ->newQuery()
                    ->where('user_id', $id)
                    ->get()
                    ->toArray();
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

    /**
     * @inheritdoc
     */
    public function update(int $id, array $attributes): bool
    {
        return \boolval(
            $this->contacts
                 ->newQuery()
                 ->whereKey($id)
                 ->update($attributes)
        );
    }
}
