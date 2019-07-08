<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'registered'
    ];

    public function routes() {
        return $this->hasMany('App\Route');
    }

    public function cars() {
        return $this->hasMany('App\Car');
    }

    public function bookings() {
        return $this->hasMany('App\Booking');
    }

    public function messages() {
        return $this->hasMany('App\Messages');
    }
}
