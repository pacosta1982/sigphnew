@extends('adminlte::page')

@section('title', 'FONAVIS')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{url('actualizacion')}}"><i class="fa fa-home"></i>Inicio</a></li>
  </ol>
@stop

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">

        <div class="pull-right"><a  class="announce">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-default"   type="button"><i class="fa fa-fw fa-plus"></i> Crear Proyecto</button>
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
        <td>{{$project->name}}</td>
        <td>{{$project->sat_id?$project->getSat->NucNomSat:""}}</td>
        <td>{{utf8_encode($project->land_id?$project->getLand->name:"")}}</td>
        <td>{{utf8_encode($project->state_id?$project->getState->DptoNom:"")}}</td>
        <td>{{utf8_encode($project->city_id)}}</td>
        <td>{{utf8_encode($project->modalidad_id?$project->getModality->name:"")}}</td>
        <td>
                @if (isset($project->getEstado->stage_id))
                <label for="" class="text-green"> {{ $project->getEstado->stage_id?$project->getEstado->getStage->name:"" }}</label>
                @else
                <label for="" class="text-yellow">Pendiente</label>
                @endif
        </td>
        <td style="text-align:center; width: 150px;">
                <div class="btn-group">
                        <button type="button" class="btn btn-info">Acciones</button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{!! action('ActualizacionController@show', ['id'=>$project->id]) !!}">Ver</a></li>
                          @if (!isset($project->getEstado->stage_id))
                          <li><a href="{!! action('ActualizacionController@edit', ['id'=>$project->id]) !!}">Editar</a></li>
                          @endif
                          <li><a href="{!! action('PostulantesActualizacionController@index', ['id'=>$project->id]) !!}">Postulantes</a></li>
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

  <div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Ingrese Número de Expediente</h4>
        </div>
        <div class="modal-body">
            <form action="{{ action('ActualizacionController@create') }}" method="GET">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="expediente"  value="">
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
