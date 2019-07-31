<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
    protected $fillable = ['first_name', 'last_name', 'cedula','marital_status','nacionalidad','gender','birthdate','localidad',
    'asentamiento','ingreso','address','grupo','phone','mobile'];


    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}
