<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class Users extends Model implements CanResetPasswordContract
{
    use CanResetPassword, Notifiable;

    protected $fillable = ['first_name', 'last_name', 'password', 'email', 'phone'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Companies::class, 'user_id');
    }

    public function getId()
    {
        return $this->id;
    }

}
