<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Land;
use App\Models\Project;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Modality;
use App\Http\Requests\StoreProject;

class ProjectController extends Controller
{

    public $statesInit;

    public function __construct()
    {
        $this->middleware('auth');

        //$this->statesInit = State::all()->sortBy("name");

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Lista de Proyectos";
        $projects = Project::all();
        //Mapper::map(-24.3697635, -56.5912129, ['zoom' => 6, 'type' => 'ROADMAP']);
        return view('projects.index',compact('projects','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title="Crear Proyecto";
        $tierra = Land::all();
        $modalidad = Modality::all();
        $departamentos = Departamento::where('DptoId','<',18)
                        ->orderBy('DptoNom', 'asc')->get();
        return view('projects.create',compact('title','tierra','departamentos','modalidad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        //
        Project::create($request->all());
        return redirect('projects/')->with('success', 'Se ha agregado un Nuevo Proyecto!');
        //return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title="Editar Proyecto";
        $tierra = Land::all();
        $modalidad = Modality::all();
        $departamentos = Departamento::where('DptoId','<',18)
                        ->orderBy('DptoNom', 'asc')->get();
        $project=Project::find($id);
        $cities = $this->distrito($project->state_id);
        $cities = json_decode($cities, true);
        return view('projects.create',compact('title','tierra','departamentos','modalidad','project','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProject $request, $id)
    {
        //
        $project = Project::find($id);
        $project->name = $request->input("name");
        $project->phone = $request->input("phone");
        $project->state_id = $request->input("state_id");
        $project->city_id = $request->input("city_id");
        $project->land_id = $request->input("land_id");
        $project->modalidad_id = $request->input("modalidad_id");
        $project->save();

        return redirect('projects')->with('status', 'El proyecto fue actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function distrito($dptoid){
        $dpto = Distrito::where('CiuDptoID', $dptoid)->get()->sortBy("CiuNom")->pluck("CiuNom","CiuId");
        return json_encode($dpto);
    }
}
