<?php
namespace NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent;

use NunoLopes\LaravelContactsAPI\Contracts\Database\UsersRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\User as Model;
use NunoLopes\LaravelContactsAPI\Entities\User;

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
        if ($id < 0) {
            throw new \InvalidArgumentException('User\'s id should be a positive number');
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