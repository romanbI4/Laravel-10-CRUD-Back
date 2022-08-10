<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Users extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $fillable = ['first_name', 'last_name', 'password', 'email', 'phone'];

    protected $hidden = [
        'password'
    ];

    public function companies()
    {
        return $this->hasMany('App\Companies','user_id');
    }
}
