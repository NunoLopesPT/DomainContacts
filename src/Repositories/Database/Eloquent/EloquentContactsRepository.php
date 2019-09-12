<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Database\ContactsRepository;
use NunoLopes\DomainContacts\Eloquent\Contact as Model;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Contacts\ContactNotFound;

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
    public function get(int $id): Contact
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Contact\'s ID should be a positive number');
        }

        $contact = $this->contacts
                        ->newQuery()
                        ->whereKey($id)
                        ->first();

        if ($contact === null) {
            throw new ContactNotFound();
        }

        return new Contact($contact->getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function create(Contact $contact): int
    {
        $contact = $this->contacts
                        ->newQuery()
                        ->create($contact->getAttributes());

        return $contact->id;
    }

    /**
     * @inheritdoc
     */
    public function findByUserId(int $id): array
    {
        // Find all contacts that belong to the User ID.
        $contacts = $this->contacts
                         ->newQuery()
                         ->where('user_id', $id)
                         ->get();

        // Convert each Contact Model to Contact Entity and add to an array to return.
        $result = [];
        foreach ($contacts as $contact) {
            $result[] = new Contact($contact->getAttributes());
        }

        return $result;
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
    public function update(Contact $contact): bool
    {
        // Throws Exception if the contact has ID.
        if (!$contact->hasId()) {
            throw new \UnexpectedValueException('Contact has no ID.');
        }

        // Get the changed attributes.
        $dirtyAttributes = $contact->getDirtyAttributes();

        // If there are no changed attributes, no need to make a query.
        if (empty($dirtyAttributes)) {
            return false;
        }

        // The update returns the number of affected rows, because in this case
        // the maximum amount of contacts we can update is one, we set the int to boolean.
        return \boolval(
            $this->contacts
                 ->newQuery()
                 ->whereKey($contact->id())
                 ->update($dirtyAttributes)
        );
    }
}
