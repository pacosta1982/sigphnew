<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Land;
use App\Models\Project;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Modality;
use App\Models\Document;
use App\Models\Documents;
use App\Models\Assignment;
use App\Models\Typology;
use App\Models\Land_project;
use App\Models\ModalityHasLand;
use App\Models\Project_tipologies;
use App\User;

use App\Http\Requests\StoreProject;

class ProjectController extends Controller
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
        $title="Lista de Proyectos";

        $id = Auth::user()->id;
        $currentuser = User::find($id);

        $projects = Project::where('sat_id', $currentuser->sat_ruc)->get();
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
        $tipologias = Typology::all();
        return view('projects.create',compact('title','tierra','departamentos','modalidad','tipologias'));
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
        //return $request;
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
        return view('projects.show',compact('title','project','documentos','docproyecto','tipoproy'));
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
        $tipologias = Typology::all();
        return view('projects.create',compact('title','tierra','departamentos','modalidad','project','cities','tipologias'));
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
        $project->leader_name = $request->input("leader_name");
        $project->localidad = $request->input("localidad");
        $project->typology_id = $request->input("typology_id");
        $project->save();

        return redirect('projects')->with('success', 'El proyecto fue actualizado!');
    }

    public function upload(Request $request)
    {
    	/*$this->validate($request, [
    		//'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/


        $input['file_path'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/'.$request->project_id.'/project/general'), $input['file_path']);

        $title = Document::find($request->title);
        //return $title->name;
        $input['title'] = $title->name;
        $input['project_id'] = $request->project_id;
        $input['document_id'] = $request->title;
        Documents::create($input);

        //return $input;

    	return back()
            ->with('success', 'Se ha agregado un Archivo!');
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
        $dpto = Project_tipologies::join('typologies', 'project_type_has_typologies.typology_id', '=', 'typologies.id')
        ->where('project_type_id',$tipo->project_type_id)->get()->sortBy("name")->pluck("name","typology_id");
        return json_encode($dpto, JSON_UNESCAPED_UNICODE);
    }
}
