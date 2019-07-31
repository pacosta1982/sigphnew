<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Postulante;
use GuzzleHttp\Client;
use App\Models\ProjectHasPostulantes;
use App\Models\Document;
use App\Models\PostulantesDocuments;
use App\Models\Assignment;

class PostulantesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->photos_path = public_path('/images');

    }

    public function index($id)
    {
        $title="Lista de Postulantes";
        $project = Project::find($id);
        $postulantes = ProjectHasPostulantes::where('project_id',$id)->get();
        //Mapper::map(-24.3697635, -56.5912129, ['zoom' => 6, 'type' => 'ROADMAP']);
        return view('postulantes.index',compact('project','title','postulantes'));
        //return "hola";
    }

    public function create(Request $request, $id){

        if ($request->input('cedula')) {
            $existe = Postulante::where('cedula',$request->input('cedula'))->get();
            if($existe->count() >= 1){
                //Session::flash('error', 'Ya existe el postulante!');
                return redirect()->back()->with('error', 'Ya existe el postulante!');
            }

            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            $GetOrder = [
                'username' => 'senavitatconsultas',
                'password' => 'S3n4vitat'
            ];
            $client = new client();
            $res = $client->post('http://10.1.79.7:8080/mbohape-core/sii/security', [
                'headers' => $headers,
                'json' => $GetOrder,
                'decode_content' => false
            ]);
            //var_dump((string) $res->getBody());
            $contents = $res->getBody()->getContents();
            $book = json_decode($contents);
            //echo $book->token;
            if($book->success == true){
                //obtener la cedula
                $headerscedula = [
                    'Authorization' => 'Bearer '.$book->token,
                    'Accept' => 'application/json',
                    'decode_content' => false
                ];
                $cedula = $client->get('http://10.1.79.7:8080/frontend-identificaciones/api/persona/obtenerPersonaPorCedula/'.$request->input('cedula'), [
                    'headers' => $headerscedula,
                ]);
                $datos=$cedula->getBody()->getContents();
                $datospersona = json_decode($datos);
                if(isset($datospersona->obtenerPersonaPorNroCedulaResponse->return->error)){
                    //Flash::error($datospersona->obtenerPersonaPorNroCedulaResponse->return->error);
                    //Session::flash('error', $datospersona->obtenerPersonaPorNroCedulaResponse->return->error);
                    return redirect()->back()->with('error', $datospersona->obtenerPersonaPorNroCedulaResponse->return->error);
                }else{
                    $nombre = $datospersona->obtenerPersonaPorNroCedulaResponse->return->nombres;
                    $apellido = $datospersona->obtenerPersonaPorNroCedulaResponse->return->apellido;
                    $cedula = $datospersona->obtenerPersonaPorNroCedulaResponse->return->cedula;
                    $sexo = $datospersona->obtenerPersonaPorNroCedulaResponse->return->sexo;
                    $fecha = date('Y-d-m H:i:s.v', strtotime($datospersona->obtenerPersonaPorNroCedulaResponse->return->fechNacim));
                    $nac = $datospersona->obtenerPersonaPorNroCedulaResponse->return->nacionalidadBean;
                    $est = $datospersona->obtenerPersonaPorNroCedulaResponse->return->estadoCivil;
                    //$prof = $datospersona->obtenerPersonaPorNroCedulaResponse->return->profesionBean;
                    $nroexp = $cedula;
                    $title="Agregar Postulante";
                    $project_id = Project::find($id);
                        //var_dump($datospersona->obtenerPersonaPorNroCedulaResponse);
                    return view('postulantes.create',compact('nroexp','cedula','nombre','apellido','fecha','sexo',
                    'nac','est','title','project_id'/*'parentesco','escolaridad','discapacidad','enfermedad','entidades'*/));
                }

                //$nombre = $datos->nombres;
                //echo $cedula->getBody()->getContents();
            }else{
                //Flash::success($book->message);
                return redirect()->back();
            }
        }else{

            //$nroexp = '';
            //return view('home',compact('nroexp'));
            return redirect()->back()->with('error', 'Ingrese Cédula');
        }



        //return view('home',compact('expediente','historial'));

        $title="Agregar Postulante";
        return view('postulantes.create',compact('title'));
    }


    public function store(Request $request)
    {
        $input = $request->except(['_token','project_id']);
        $postulante = Postulante ::create($input);

        $proypostulante = new ProjectHasPostulantes();
        $proypostulante->project_id=$request->project_id;
        $proypostulante->postulante_id=$postulante->id;
        $proypostulante->save();
        //ProjectHasPostulantes::

        //return $request->all();
        //Postulante ::create($request->all());
        return redirect('projects/'.$request->project_id.'/postulantes')->with('success', 'Se ha agregado un nuevo Postulante!');
        //return $request;
    }

    public function show($id,$idpostulante)
    {
        $postulante=Postulante::find($idpostulante);
        $project = Project::find($id);
        $title="Resumen Postulante ";
        //dd($project);
        $documentos = PostulantesDocuments::where('postulante_id',$idpostulante)->get();
        $docproyecto = Assignment::where('land_id',$project->land_id)
        ->whereNotIn('document_id', $documentos->pluck('document_id'))
        ->where('category_id',2)
        ->get();
        //$docproyecto = $docproyecto->whereNotIn('document_id', $documentos->pluck('document_id'));
        return view('postulantes.show',compact('title','project','documentos','docproyecto','postulante'));
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
        $input['postulante_id'] = $request->postulante_id;
        $input['document_id'] = $request->title;
        PostulantesDocuments::create($input);

        //return $input;

    	return back()
            ->with('success', 'Se ha agregado un Archivo!');
    }

    public function destroyfile(Request $request)
    {
    	//Documents::find($id)->delete();
        //return back()->with('error', 'Se ha eliminado el archivo!');
        //return $request;
        $file = PostulantesDocuments::find($request->delete_id);

        $file_path = $this->photos_path . '/' . $file->project_id . '/project/general/' . $file->file_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        PostulantesDocuments::find($request->delete_id)->delete();
        return back()->with('error', 'Se ha eliminado el archivo!');
    }

}
