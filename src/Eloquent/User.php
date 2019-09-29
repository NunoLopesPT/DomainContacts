<?php
namespace NunoLopes\DomainContacts\Eloquent;

use Illuminate\Database\Eloquent\Model;

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
}
