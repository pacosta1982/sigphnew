<!DOCTYPE html>
<html>
<head>
	<title>Lista de Postulantes</title>
</head>
<body>
    <img src="{{public_path('img/logofull.png')}}" class="imagencentro" width="650" >
    <h2>Proyecto: {{$project->name}}</h2>
    <h4>Código: {{$project->id}}</h4>
    <h4>Programa: FONAVIS</h4>
          <p>
          <strong>SAT:</strong>{{$project->sat_id?$project->getSat->NucNomSat:""}}<br>
            <strong>Departamento: </strong>{{$project->state_id?$project->getState->DptoNom:""}}<br>
            <strong>Distrito:</strong> {{$project->city_id}}<br>
            <strong>Modalidad:</strong> {{$project->modalidad_id?$project->getModality->name:""}}<br>
            <strong>Tipo de Terreno:</strong> {{$project->land_id?$project->getLand->name:""}}<br>
            <strong>Total Postulantes:</strong> {{ $postulantes->count() }}<br>
          </p>
      <h2>Lista de Postulantes</h2>
    <table class="table">
        <tbody>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th class="text-center">Cédula</th>
          <th class="text-center">Edad</th>
          <th class="text-center">Ingreso</th>
          <th class="text-center">Nivel</th>
          <th class="text-center">Miembros</th>

        </tr>
        @foreach($postulantes as $key=>$post)
        <tr>
          <td>{{$key+1}}</td>
          <td>{{ $post->postulante_id?$post->getPostulante->first_name:"" }} {{ $post->postulante_id?$post->getPostulante->last_name:"" }}</td>
          <td class="text-center">{{ number_format($post->postulante_id?$post->getPostulante->cedula:"",0,".",".") }} </td>
          <td class="text-center">{{ \Carbon\Carbon::parse($post->postulante_id?$post->getPostulante->birthdate:"")->age }} </td>
          <td class="text-center">{{ number_format(App\Models\ProjectHasPostulantes::getIngreso($post->postulante_id),0,".",".") }} </td>
          <td class="text-center">{{ App\Models\ProjectHasPostulantes::getNivel($post->postulante_id) }}</td>
          <td class="text-center">{{ $post->getMembers->count() + 1 }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>
</html>
