<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sat extends Model
{
    //
    protected $table = 'SHMNUC';
    protected $primaryKey = 'NucCod';
    public $timestamps = false;
    protected $connection = 'sqlsrvsecond';

}
