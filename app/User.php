<?php

namespace BoardGameTracker;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Set relation to plays
    public function plays(){
        $this->hasMany('App\plays');
    }

    //Set relation to collections
    public function collections(){
        $this->hasMany('App\Collection');
    }
}
