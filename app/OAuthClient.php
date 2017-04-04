<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * OAuthClient Model
 * Class OAuthClient
 * @package App
 */
class OAuthClient extends Model
{
    protected $table = 'oauth_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'secret', 'name',
    ];
}
