<?php
namespace NunoLopes\DomainContacts\Eloquent;

use Illuminate\Database\Eloquent\Model;

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
    protected $table = 'access_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token_id',
        'user_id',
        'revoked',
        'expires_at',
    ];
}
