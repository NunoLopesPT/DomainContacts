<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\UsersRepository;
use NunoLopes\DomainContacts\Eloquent\User as Model;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserAlreadyCreatedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;

/**
 * Class EloquentUsersRepository.
 */
class EloquentUsersRepository implements UsersRepository
{
    /**
     * @var Model $users - User's Eloquent model instance.
     */
    protected $users = null;

    /**
     * Initializes the User's Repository instance.
     *
     * @param Model $user - User's Eloquent Model instance.
     */
    public function __construct(Model $user) {
        $this->users = $user;
    }

    /**
     * @inheritdoc
     */
    public function get(int $id): User
    {
        // Throw exception if the id is invalid.
        if ($id <= 0) {
            throw new \InvalidArgumentException('User\'s ID should be a positive number');
        }

        // Try to find the user.
        $user = $this->users
                     ->newQuery()
                     ->whereKey($id)
                     ->first();

        // Throw exception if it doesn't exist.
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new User($user->getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function create(User $user): User
    {
        // Throw exception if the user already has an ID.
        if ($user->hasId()) {
            throw new UserAlreadyCreatedException();
        }

        // Create the User in the database.
        $model = $this->users
                      ->newQuery()
                      ->create($user->getAttributes());

        // Set the new attributes in the original Entity.
        $user->setAttributes($model->getAttributes());

        // Commit changes in case entity has dirty attributes.
        $user->commit();

        // Return the same instance with updated attributes.
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getByEmail(string $email): ?User
    {
        // Throw exception if the email is empty.
        if (\strlen(\trim($email)) === 0) {
            throw new \InvalidArgumentException('User\'s email is empty.');
        }

        $user = $this->users
            ->newQuery()
            ->where('email', $email)
            ->first();

        // Throw exception if the user was not found.
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return new User($user->getAttributes());
    }
}
