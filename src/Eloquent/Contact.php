<?php
namespace NunoLopes\LaravelContactsAPI\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Contact Eloquent's Model class
 *
 * This class will be used for communicating with the database's 'contacts' table.
 *
 * @property int    id           - Id of the contact.
 * @property int    user_id      - Id of the user who created the contact.
 * @property string first_name   - First name of the contact.
 * @property string last_name    - Last name of the contact.
 * @property string email        - Email of the contact.
 * @property string phone_number - Phone number of the contact.
 */
class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'user_id',
    ];

    /**
     * Will return the User of the Contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
