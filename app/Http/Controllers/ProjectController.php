<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Land;
use App\Models\Project;
use App\Models\Departamento;
use App\Models\Distrito;

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
        $departamentos = Departamento::orderBy('DptoNom', 'asc')->get();
        return view('projects.create',compact('title','tierra','departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
