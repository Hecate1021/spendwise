<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'profilePicture',
        'is_verified',
        'verification_code',
        'code_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
public function feedbacks()
{
    return $this->hasMany(Feedback::class, 'username', 'username');
}


}
