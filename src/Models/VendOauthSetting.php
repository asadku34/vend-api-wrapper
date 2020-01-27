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
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
