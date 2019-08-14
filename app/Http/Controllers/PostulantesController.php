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
use App\Models\Land_project;
use App\Models\Discapacidad;
use App\Models\Parentesco;
use App\Models\PostulanteHasDiscapacidad;
use App\Models\PostulanteHasBeneficiary;
use App\Http\Requests\StorePostulante;
use PDF;

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
                    //$parentesco = Parentesco::all();
                    $discapacdad = Discapacidad::all();
                        //var_dump($datospersona->obtenerPersonaPorNroCedulaResponse);
                    return view('postulantes.create',compact('nroexp','cedula','nombre','apellido','fecha','sexo',
                    'nac','est','title','project_id','discapacdad'/*,'escolaridad','discapacidad','enfermedad','entidades'*/));
                }

                //$nombre = $datos->nombres;
                //echo $cedula->getBody()->getContents();
            }else{
                //Flash::success($book->message);
                return redirect()->back();
            }
        }else{

            return redirect()->back()->with('error', 'Ingrese Cédula');
        }

        $title="Agregar Postulante";
        return view('postulantes.create',compact('title'));
    }


    public function createmiembro(Request $request, $id){

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
                    $title="Agregar Miembro Familiar";
                    $project_id = Project::find($id);
                    $parentesco = Parentesco::all();
                    $discapacdad = Discapacidad::all();
                    $idpostulante = $request->postulante_id;
                        //var_dump($datospersona->obtenerPersonaPorNroCedulaResponse);
                    return view('postulantes.ficha.createmiembro',compact('nroexp','cedula','nombre','apellido','fecha','sexo',
                    'nac','est','title','project_id','discapacdad','idpostulante','parentesco'/*,'escolaridad','discapacidad','enfermedad','entidades'*/));
                }

                //$nombre = $datos->nombres;
                //echo $cedula->getBody()->getContents();
            }else{
                //Flash::success($book->message);
                return redirect()->back();
            }
        }else{

            return redirect()->back()->with('error', 'Ingrese Cédula');
        }

        $title="Agregar Postulante";
        return view('postulantes.create',compact('title'));
    }


    public function store(StorePostulante $request)
    {


        //return $request;

        $input = $request->except(['_token','project_id','discapacidad_id']);
        $postulante = Postulante ::create($input);

        $proypostulante = new ProjectHasPostulantes();
        $proypostulante->project_id=$request->project_id;
        $proypostulante->postulante_id=$postulante->id;
        $proypostulante->save();



        $postulantediscapacidad = new PostulanteHasDiscapacidad();
        $postulantediscapacidad->discapacidad_id=$request->discapacidad_id;
        $postulantediscapacidad->postulante_id=$postulante->id;
        $postulantediscapacidad->save();
        //ProjectHasPostulantes::

        //return $request->all();
        //Postulante ::create($request->all());
        return redirect('projects/'.$request->project_id.'/postulantes')->with('success', 'Se ha agregado un nuevo Postulante!');
        //return $request;
    }

    public function storemiembro(Request $request)
    {
        //return $request;
        $input = $request->except(['_token','project_id','discapacidad_id','postulante_id']);
        $postulante = Postulante ::create($input);

        $miembro = new PostulanteHasBeneficiary();
        $miembro->postulante_id=$request->postulante_id;
        $miembro->miembro_id=$postulante->id;
        $miembro->parentesco_id=$request->parentesco_id;
        $miembro->save();

        $postulantediscapacidad = new PostulanteHasDiscapacidad();
        $postulantediscapacidad->discapacidad_id=$request->discapacidad_id;
        $postulantediscapacidad->postulante_id=$postulante->id;
        $postulantediscapacidad->save();
        //ProjectHasPostulantes::

        //return $request->all();
        //Postulante ::create($request->all());
        return redirect('projects/'.$request->project_id.'/postulantes/'.$request->postulante_id)->with('success', 'Se ha agregado un nuevo Miembro!');
        //return $request;
    }

    public function show($id,$idpostulante)
    {
        $postulante=Postulante::find($idpostulante);
        $project = Project::find($id);
        $title="Resumen Postulante ";
        //dd($project);
        $tipoproy = Land_project::where('land_id',$project->land_id)->first();
        $documentos = PostulantesDocuments::where('postulante_id',$idpostulante)->get();
        $docproyecto = Assignment::where('project_type_id',$tipoproy->land_id)
        ->whereNotIn('document_id', $documentos->pluck('document_id'))
        ->where('category_id',2)
        ->get();
        $miembros = PostulanteHasBeneficiary::where('postulante_id',$postulante->id)->get();
        //$docproyecto = $docproyecto->whereNotIn('document_id', $documentos->pluck('document_id'));
        return view('postulantes.show',compact('title','project','miembros','documentos','docproyecto','postulante'));
    }

    public function edit($id,$idpostulante)
    {
        $title="Editar Postulante";
        $project=Project::find($id);
        $postulante=Postulante::find($idpostulante);
        $nombre = $postulante->first_name;
        $apellido = $postulante->last_name;
        $cedula = $postulante->cedula;
        $sexo = $postulante->gender;
        $project_id = Project::find($id);
        $nac = $postulante->nacionalidad;
        $est = $postulante->marital_status;
        $fecha = $postulante->birthdate;
        $discapacdad = Discapacidad::all();
        $disc = PostulanteHasDiscapacidad::where('postulante_id',$postulante->id)->first();

        return view('postulantes.create',compact('title','project','postulante','apellido','cedula','sexo','project_id',
                                                'nombre','nac','est','fecha','discapacdad','disc'));
    }

    public function editmiembro($id,$idpostulante)
    {
        $title="Editar Miembro";
        $project=Project::find($id);
        $postulante=Postulante::find($idpostulante);
        $nombre = $postulante->first_name;
        $apellido = $postulante->last_name;
        $cedula = $postulante->cedula;
        $sexo = $postulante->gender;
        $project_id = Project::find($id);
        $nac = $postulante->nacionalidad;
        $est = $postulante->marital_status;
        $fecha = $postulante->birthdate;
        $discapacdad = Discapacidad::all();
        $disc = PostulanteHasDiscapacidad::where('postulante_id',$postulante->id)->first();
        $parentesco = Parentesco::all();
        $parent = PostulanteHasBeneficiary::where('miembro_id',$postulante->id)->first();
        $idpostulante=$parent->postulante_id;

        return view('postulantes.ficha.createmiembro',compact('title','project','postulante','apellido','cedula','sexo','project_id',
                                                'nombre','nac','est','fecha','discapacdad','disc','parentesco','parent','idpostulante'));
    }

    public function update(Request $request)
    {
        //
        //return $request;
        $postulante = Postulante::find($request->input("id"));
        $postulante->localidad = $request->input("localidad");
        $postulante->address = $request->input("address");
        $postulante->cedula = $request->input("cedula");
        $postulante->phone = $request->input("phone");
        $postulante->asentamiento = $request->input("asentamiento");
        $postulante->ingreso = $request->input("ingreso");
        $postulante->mobile = $request->input("mobile");
        $postulante->save();

        $disc = PostulanteHasDiscapacidad::find($request->input("disc_id"));
        $disc->discapacidad_id=$request->discapacidad_id;
        $disc->save();






        return redirect('projects/'.$request->input("project_id").'/postulantes')->with('success', 'El postulante fue actualizado!');
    }

    public function updatemiembro(Request $request)
    {
        //
        //return $request;
        $postulante = Postulante::find($request->input("id"));
        $postulante->localidad = $request->input("localidad");
        $postulante->address = $request->input("address");
        $postulante->cedula = $request->input("cedula");
        $postulante->phone = $request->input("phone");
        $postulante->asentamiento = $request->input("asentamiento");
        $postulante->ingreso = $request->input("ingreso");
        $postulante->mobile = $request->input("mobile");
        $postulante->save();

        $disc = PostulanteHasDiscapacidad::find($request->input("disc_id"));
        $disc->discapacidad_id=$request->discapacidad_id;
        $disc->save();

        $parent = PostulanteHasBeneficiary::find($request->input("parent_id"));
        $parent->parentesco_id=$request->parentesco_id;
        $parent->save();

        return redirect('projects/'.$request->input("project_id").'/postulantes/'.$request->input("postulante_id"))->with('success', 'El miembro fue actualizado!');
    }

    public function generatePDF($id)
    {
        $project=Project::find($id);
        $postulantes = ProjectHasPostulantes::where('project_id',$id)->get();
        $data = ['title' => 'Welcome to HDTuto.com',
                'project' => $project,
                'postulantes' => $postulantes
                ];
        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('postulantes.pdf');
    }



    public function upload(Request $request)
    {

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

        $file = PostulantesDocuments::find($request->delete_id);

        $file_path = $this->photos_path . '/' . $file->project_id . '/project/general/' . $file->file_path;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        PostulantesDocuments::find($request->delete_id)->delete();
        return back()->with('error', 'Se ha eliminado el archivo!');
    }

}
