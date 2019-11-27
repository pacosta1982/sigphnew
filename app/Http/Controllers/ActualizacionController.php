<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Land;
use App\Models\Project;
use App\Models\Departamento;
use App\Models\Modality;
use App\Models\Typology;
use App\Models\Land_project;
use App\Models\Documents;
use App\Models\SIG005;
use App\Models\Assignment;
use App\Models\ModalityHasLand;
use App\Models\Project_tipologies;
use App\User;

class ActualizacionController extends Controller
{
    public $statesInit;

    public function __construct()
    {
        $this->middleware('auth');
        $this->photos_path = public_path('/images');

        //$this->statesInit = State::all()->sortBy("name");

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Actualización de Proyectos";
        $id = Auth::user()->id;
        $currentuser = User::find($id);


        $projects = Project::where('sat_id', $currentuser->sat_ruc)
        ->where('action','update')
        ->get();


        return view('actualizacionprojects.index',compact('projects','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ver = SIG005::where('NroExp',$request->expediente)
        ->where('NroExpS','A')
        ->first();

        if ($ver) {
            $title="Crear Proyecto de Actualización";
            $tierra = Land::all();
            $modalidad = Modality::all();
            $departamentos = Departamento::where('DptoId','<',18)
                            ->orderBy('DptoNom', 'asc')->get();
            $tipologias = Typology::all();
            $exp = $request->expediente;
            return view('actualizacionprojects.create',compact('title','tierra','departamentos','modalidad','tipologias','exp'));
        } else {
            return redirect('actualizacion')->with('error', 'El expediente no existe!');
        }



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
        //return $request;
        Project::create($request->all());
        return redirect('actualizacion/')->with('success', 'Se ha agregado un Nuevo Proyecto!');
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
        $project=Project::find($id);
        $title="Resumen Proyecto ".$project->name;

        $tipoproy = Land_project::where('land_id',$project->land_id)->first();
        //dd($tipoproy);
        $documentos = Documents::where('project_id',$id)->get();

        $docproyecto = Assignment::where('project_type_id',$tipoproy->project_type_id)

        ->whereNotIn('document_id', $documentos->pluck('document_id'))
        ->where('category_id',1)
        ->where('stage_id',1)
        ->get();
        //dd($docproyecto);
        //$docproyecto = $docproyecto->whereNotIn('document_id', $documentos->pluck('document_id'));
        return view('actualizacionprojects.show',compact('title','project','documentos','docproyecto','tipoproy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title="Editar Proyecto de Actualización";
        $tierra = Land::all();
        $modalidad = Modality::all();
        $departamentos = Departamento::where('DptoId','<',18)
                        ->orderBy('DptoNom', 'asc')->get();
        $project=Project::find($id);
        //$cities = $this->distrito($project->state_id);
        //$cities = json_decode($cities, true);
        $tipologias = Typology::all();

        $lands = $this->lands($project->land_id);
        $lands = json_decode($lands, true);

        $typology = $this->typologyedit($project->typology_id);
        $typology = json_decode($typology, true);
        return view('actualizacionprojects.create',compact('title','tierra','typology','lands','departamentos','modalidad','project','tipologias'));
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
        $project = Project::find($id);
        $project->name = $request->input("name");
        $project->phone = $request->input("phone");
        $project->state_id = $request->input("state_id");
        $project->city_id = $request->input("city_id");
        $project->land_id = $request->input("land_id");
        $project->modalidad_id = $request->input("modalidad_id");
        $project->leader_name = $request->input("leader_name");
        $project->localidad = $request->input("localidad");
        $project->typology_id = $request->input("typology_id");
        //$project->expsocial = $request->input("expsocial");
        $project->exptecnico = $request->input("exptecnico");
        $project->save();

        return redirect('actualizacion')->with('success', 'El proyecto fue actualizado!');
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


    public function send(Request $request)
    {
        //return $request;
        $state = new ProjectStatus();
        $state->project_id=$request->send_id;
        $state->stage_id='1';
        $state->user_id=Auth::user()->id;
        $state->record='Proyecto Enviado!';
        $state->save();
        return redirect('projects/'.$request->send_id.'/postulantes')->with('success', 'El proyecto se ha enviado a MUVH correctamente!');
    }

    public function destroyfile(Request $request)
    {
    	//Documents::find($id)->delete();
        //return back()->with('error', 'Se ha eliminado el archivo!');
        //return $request;
        $file = Documents::find($request->delete_id);

        $file_path = $this->photos_path . '/' . $file->project_id . '/project/general/' . $file->file_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        Documents::find($request->delete_id)->delete();
        return back()->with('error', 'Se ha eliminado el archivo!');
    }

    public function distrito($dptoid){
        $dpto = Distrito::where('CiuDptoID', $dptoid)->get()->sortBy("CiuNom")->pluck("CiuNom","CiuId");
        //return json_encode($dpto, JSON_FORCE_OBJECT);
        return json_encode($dpto , JSON_UNESCAPED_UNICODE);
    }


    public function distritosinjson($dptoid){
        //$dpto =
        return Distrito::where('CiuDptoID', $dptoid)->get()->sortBy("CiuNom")->pluck("CiuNom","CiuId");
        //return json_encode($dpto, JSON_FORCE_OBJECT);
        //return json_encode($dpto , JSON_UNESCAPED_UNICODE);
    }

    public function lands($dptoid){
        $dpto = ModalityHasLand::join('lands', 'modality_has_lands.land_id', '=', 'lands.id')
        ->where('modality_id', $dptoid)->get()->sortBy("name")->pluck("name","land_id");
        return json_encode($dpto, JSON_UNESCAPED_UNICODE);
    }

    public function typology($dptoid){
        $tipo = Land_project::where('land_id',$dptoid)->first();
        //dd($tipo);
        $dpto = Project_tipologies::join('typologies', 'project_type_has_typologies.typology_id', '=', 'typologies.id')
        ->where('project_type_id',$tipo->project_type_id)->get()->sortBy("name")->pluck("name","typology_id");
        return json_encode($dpto, JSON_UNESCAPED_UNICODE);
    }

    public function typologyedit($dptoid){
        //$tipo = Land_project::where('land_id',$dptoid)->first();
        //dd($tipo);
        $dpto = Project_tipologies::join('typologies', 'project_type_has_typologies.typology_id', '=', 'typologies.id')
        ->where('typology_id',$dptoid)->get()->sortBy("name")->pluck("name","typology_id");
        return json_encode($dpto, JSON_UNESCAPED_UNICODE);
    }
}
