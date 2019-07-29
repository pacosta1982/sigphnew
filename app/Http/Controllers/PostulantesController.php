<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectHasPostulantes;

class PostulantesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index($id)
    {
        $title="Lista de Postulantes";
        $project = Project::find($id);
        $postulantes = ProjectHasPostulantes::where('project_id',$id);
        //Mapper::map(-24.3697635, -56.5912129, ['zoom' => 6, 'type' => 'ROADMAP']);
        return view('postulantes.index',compact('project','title','postulantes'));
        //return "hola";
    }

}
