@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
    <li class="active"><a href="#">Postulantes del Proyecto {{ $project->name }}</a></li>
  </ol>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-university"></i> {{ $project->name }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <p>
                <strong>Departamento: </strong>{{$project->state_id?$project->getState->DptoNom:""}}<br>
                <strong>Distrito:</strong> {{$project->city_id?$project->getCity->CiuNom:""}}<br>
                <strong>Modalidad:</strong> {{$project->modalidad_id?$project->getModality->name:""}}<br>
              </p>
            </div>
              <div class="col-md-4">
                <p>
                    <strong>SAT:</strong> {{$project->sat_id?$project->getSat->NucNomSat:""}}<br>
                    <strong>Tipo de Terreno:</strong> {{$project->land_id?$project->getLand->name:""}}<br>
                    <strong>Total Postulantes:</strong> {{ $postulantes->count() }}<br>
                </p>
              </div>
              <div class="col-md-4">
                <p class="text-center">

                </p>

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-users"></i> Postulantes</h3>
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
            <i class="fa fa-plus-circle"></i> Agregar Postulante
            </button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tbody>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th class="text-center">Cédula</th>
              <th class="text-center">Edad</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Miembros</th>
              <th class="text-center">Acciones</th>
            </tr>
            @foreach($postulantes as $key=>$post)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{ $post->postulante_id?$post->getPostulante->first_name:"" }} {{ $post->postulante_id?$post->getPostulante->last_name:"" }}</td>
              <td class="text-center">{{ number_format($post->postulante_id?$post->getPostulante->cedula:"",0,".",".") }} </td>
              <td class="text-center">{{ \Carbon\Carbon::parse($post->postulante_id?$post->getPostulante->birthdate:"")->age }} </td>
              <td class="text-center">{{ number_format($post->postulante_id?$post->getPostulante->ingreso:"",0,".",".") }} </td>
              <td class="text-center">{{ $post->getMembers->count() + 1 }}</td>
              <td class="text-center">
                    <div class="btn-group">
                            <button type="button" class="btn btn-info">Acciones</button>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="{!! action('PostulantesController@show', ['id'=>$project->id,'idpostulantes'=>$post->postulante_id?$post->getPostulante->id:""]) !!}">Ver</a></li>
                              <li><a href="{!! action('PostulantesController@edit', ['id'=>$project->id,'idpostulantes'=>$post->postulante_id?$post->getPostulante->id:""]) !!}">Editar</a></li>
                              <li><a href="#">Eliminar</a></li>
                            </ul>
                          </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div>
    </div>
  </div>
<!-- Modal Cedula -->

<div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Ingrese Número de Cédula</h4>
        </div>
        <div class="modal-body">
            <form action="{{ action('PostulantesController@create', ['id' => $project->id ]) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="cedula"  value="">
                    {!! $errors->first('state_id','<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
            </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


@stop
