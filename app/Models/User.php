<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class User extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'users';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name','email','username','password','sat_ruc'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $connection = 'sqlsrv';

    public function getsat() {
        return $this->hasOne('App\Models\Sat','NucCod','sat_ruc');
    }

    public function ItemDynamic()
    {
        return $this->hasOne('App\Models\Sat',rtrim('NucCod'), 'sat_ruc');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setFirstNameAttribute($value)
    {
        $this->attributes['sat_ruc'] = trim($value);
    }
}
