<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasPostulantes extends Model
{
    //
    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public function getPostulante() {
        return $this->hasOne('App\Models\Postulante','id','postulante_id');
    }
}
