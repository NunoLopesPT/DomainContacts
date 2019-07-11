<?php
namespace NunoLopes\LaravelContactsAPI\Utilities;

use Illuminate\Support\Facades\Auth;
use NunoLopes\LaravelContactsAPI\Contracts\Utilities\Authentication;
use NunoLopes\LaravelContactsAPI\Entities\User;

/**
 * Created by PhpStorm.
 * User: nuno
 * Date: 11-07-2019
 * Time: 10:53
 */
class LaravelAuthentication implements Authentication
{
    /**
     * @var Auth $auth - Authentication Manager.
     */
    protected $auth = null;

    /**
     * @inheritdoc
     */
    public function id(): int
    {
        return Auth::id();
    }

    /**
     * @inheritdoc
     */
    public function user(): User
    {
        return new User(Auth::user()->getAttributes());
    }

    /**
     * @inheritdoc
     */
    public function guest(): bool
    {
        return Auth::guest();
    }
}
