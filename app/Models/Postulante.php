<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
    //protected $dateFormat = 'Y-m-d H:i:s.v';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    /**
     * Convert a DateTime to a storable string.
     *
     * @param  \DateTime|int  $value
     * @return string
     */
    public function fromDateTime($value)
    {
        return $value->format('Y-m-d H:i:s.v');
    }

    //protected $dates = ['created_at','updated_at'];

    protected $fillable = ['first_name', 'last_name', 'cedula','marital_status','nacionalidad','gender','birthdate','localidad',
    'asentamiento','ingreso','address','grupo','phone','mobile'];




}
