<?php
namespace NunoLopes\LaravelContactsAPI\Eloquent;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;

/**
 * User Eloquent's Model class
 *
 * This class will be used for communicating with the database's 'user' table.
 *
 * @property int    id    - Id of the User.
 * @property string name  - Name of the User.
 * @property string email - Email of the User.
 */
class User extends Model
{
    use HasApiTokens, Authenticatable, CanResetPassword, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Will return the contacts of the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
