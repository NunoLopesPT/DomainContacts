<?php
namespace NunoLopes\LaravelContactsAPI\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AccessToken Eloquent's Model class
 *
 * This class will be used for communicating with the database's 'oauth_access_tokens' table.
 */
class AccessToken extends Model
{
    /**
     * @var string - AccessToken's Database Table.
     */
    protected $table = 'oauth_access_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'name',
        'revoked',
        'created_at',
        'updated_at',
        'expires_at',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Will return the User of the AccessToken.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
