<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
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
        return $this->hasMany('App\Companies', 'user_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
