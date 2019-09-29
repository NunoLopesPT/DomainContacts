<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\ContactsRepository;
use NunoLopes\DomainContacts\Eloquent\Contact as Model;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactAlreadyCreatedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotUpdatedException;

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
            throw new ContactNotFoundException();
        }

        return new Contact($contact->getAttributes());
    }

    /**
     * @inheritdoc
     *
     * @see ContactsRepository::create
     */
    public function create(Contact $contact): Contact
    {
        // Throw exception if the user already has an ID.
        if ($contact->hasId()) {
            throw new ContactAlreadyCreatedException();
        }

        // Create the Contact in the database.
        $model = $this->contacts
                        ->newQuery()
                        ->create($contact->getAttributes());

        // Set the new attributes in the original Entity.
        $contact->setAttributes($model->getAttributes());

        // Commit changes in case entity has dirty attributes.
        $contact->commit();

        // Return the same instance with updated attributes.
        return $contact;
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
    public function update(Contact $contact): Contact
    {
        // Throws Exception if the contact has ID.
        if (!$contact->hasId()) {
            throw new \UnexpectedValueException('Contact has no ID.');
        }

        // Get the changed attributes.
        $dirtyAttributes = $contact->getDirtyAttributes();

        // If there are no changed attributes, no need to make a query.
        if (empty($dirtyAttributes)) {
            return $contact;
        }

        // The update returns the number of affected rows, because in this case
        // the maximum amount of contacts we can update is one, we set the int to boolean.
        $updated = $this->contacts
                        ->newQuery()
                        ->whereKey($contact->id())
                        ->update($dirtyAttributes);

        // Throw exception if the contact was not updated.
        if (!$updated) {
            throw new ContactNotUpdatedException();
        }

        // Commit the changes.
        $contact->commit();

        // Return the contact with the committed changed.
        return $contact;
    }
}
