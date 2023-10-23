<?php

namespace Aasanakey\Smsonline\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = ['email','phone'];

    public function routeNotificationForSmsonline(){
        return $this->phone;
    }
}