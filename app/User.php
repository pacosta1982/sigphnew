<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;
use Backpack\CRUD\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one



class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $table = 'usr';
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    
    protected $connection = 'sqlsrv';

    protected $rememberTokenName = false;

    protected $fillable = [
        'name','email','username','password'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getSat() {
        return $this->hasOne('App\Models\Sat','NucRuc','sat_ruc');
    }
}
