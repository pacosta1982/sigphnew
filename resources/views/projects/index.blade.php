@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
  </ol>
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">

        <div class="pull-right"><a href="{!! action('ProjectController@create') !!}" class="announce">
            <button class="btn btn-primary" hr type="button"><i class="fa fa-fw fa-plus"></i> Crear Proyecto</button>
        </a></div>
      </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-striped">
        <tbody>
        <tr>
          <th>Proyecto</th>
          <th>Empresa/Sat</th>
          <th>Terreno</th>
          <th>Departamento</th>
          <th>Distrito</th>
          <th>Modalidad</th>
          <th>Estado</th>
          <th style="text-align:center">Acciones</th>
        </tr>
        @foreach($projects as $project)
        <tr>
        <td>{{utf8_encode($project->name)}}</td>
        <td>{{utf8_encode($project->sat_id?$project->getSat->NucNomSat:"")}}</td>
        <td>{{utf8_encode($project->land_id?$project->getLand->name:"")}}</td>
        <td>{{utf8_encode($project->state_id?$project->getState->DptoNom:"")}}</td>
        <td>{{utf8_encode($project->city_id?$project->getCity->CiuNom:"")}}</td>
        <td>{{utf8_encode($project->modalidad_id?$project->getModality->name:"")}}</td>
        <td>N/A</td>
        <td style="text-align:center">
                <div class="btn-group">
                        <button type="button" class="btn btn-info">Acciones</button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{!! action('ProjectController@show', ['id'=>$project->id]) !!}">Ver</a></li>
                          <li><a href="{!! action('ProjectController@edit', ['id'=>$project->id]) !!}">Editar</a></li>
                          <li><a href="{!! action('PostulantesController@index', ['id'=>$project->id]) !!}">Postulantes</a></li>
                        </ul>
                      </div>
        </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
            <th>Proyecto</th>
            <th>Empresa/Sat</th>
            <th>Terreno</th>
            <th>Departamento</th>
            <th>Distrito</th>
            <th>Modalidad</th>
            <th>Estado</th>
            <th style="text-align:center">Acciones</th>
        </tr>
    </tfoot>
</table>
    </div>

  </div>

@stop
