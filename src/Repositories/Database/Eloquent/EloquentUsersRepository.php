<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Database\UsersRepository;
use NunoLopes\DomainContacts\Eloquent\User as Model;
use NunoLopes\DomainContacts\Entities\User;

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
    public function get(int $id): ?User
    {
        // Throw exception if the id is invalid.
        if ($id <= 0) {
            throw new \InvalidArgumentException('User\'s ID should be a positive number');
        }

        $user = $this->users
                     ->newQuery()
                     ->whereKey($id)
                     ->first();

        return new User($user->getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function create(User $user): int
    {
        $user = $this->users
                     ->newQuery()
                     ->create($user->getAttributes());

        return $user->id;
    }

    /**
     * @inheritdoc
     */
    public function findByEmail(string $email): ?User
    {
        // Throw exception if the email is empty.
        if (\strlen(\trim($email)) === 0) {
            throw new \InvalidArgumentException('User\'s email is empty.');
        }

        $user = $this->users
            ->newQuery()
            ->where('email', $email)
            ->first();

        return new User($user->getAttributes());
    }
}
