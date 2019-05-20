<?php
namespace Asad\Vend\Models;

use Illuminate\Database\Eloquent\Model;

class VendOauthSetting extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'client_secret', 'access_token', 'refresh_token', 'protocol', 
        'token_type', 'expires_in', 'expires_in_sec', 'client_domain', 'api_domain',
        'domain_prefix', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
