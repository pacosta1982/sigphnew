@extends('adminlte::page')

@section('title', 'FONAVIS')

@section('content_header')

<ol class="breadcrumb">
<li><a href="{{url('actualizacion')}}"><i class="fa fa-home"></i>Inicio</a></li>
<li class="active"><a href="#">Resumen Proyecto</a></li>
</ol>
<br>
@stop

@section('content')

<section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-university"></i> {{ $project->name }}
          <small class="pull-right"></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
        <strong>Departamento: </strong>{{utf8_encode($project->state_id?$project->getState->DptoNom:"")}}<br>
        <strong>Distrito:</strong> {{utf8_encode($project->city_id)}}<br>
        <strong>Modalidad:</strong> {{utf8_encode($project->modalidad_id?$project->getModality->name:"")}}<br>

        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <address>
          <strong>SAT:</strong> {{utf8_encode($project->sat_id?$project->getSat->NucNomSat:"")}}<br>
          <strong>Tipo de Terreno:</strong> {{utf8_encode($project->land_id?$project->getLand->name:"")}}<br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <strong>Expediente Social: </strong> {{ $project->expsocial }}<br>
        <strong>Expediente Técnico:</strong> {{ $project->exptecnico }}<br>
      </div>
      <!-- /.col -->
    </div>
    <h4><strong>Documentos</strong></h4>
    @if (!isset($project->getEstado->stage_id))
    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
        <i class="fa fa-plus-circle"></i> Nuevo Documento
    </button>
    @endif

    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Titulo</th>
            <th class="text-center">Acciones</th>
          </tr>
          </thead>
          <tbody>
            @foreach($documentos as $doc)
            <tr>
            <td>{{utf8_encode($doc->title)}}</td>
            <td class="text-center" style="width: 220px">
                <a href="{{asset('images/')}}/{{$project->id."/project/general/".$doc->file_path}}" target="_blank">
                    <button class="btn btn-success" type="button"><i class="fa fa-download"></i> Descargar </button>
                </a>
                @if (!isset($project->getEstado->stage_id))
                <button class="btn btn-danger feed-id" type="button" data-toggle="modal"
                data-target="#modal-danger" data-id="{{ $doc->id }}" data-title="{{ $doc->title }}">
                    <i class="fa fa-close"></i> Eliminar
                </button>
                @endif
            </td>
          </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <div class="modal fade" id="modal-default" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Adjuntar Documento al Proyecto</h4>
        </div>
        <div class="modal-body">
            <form action="{{ action('ProjectController@upload') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="text" name="project_id" value="{{$project->id}}" hidden>
                <input type="text" name="num_visita"  value="" hidden>
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Documentos Requeridos</label>
                    <select class="form-control required" name="title" required>
                        <option value="">Seleccione el Documento</option>
                            @foreach($docproyecto as $key=>$doc)
                                <option value="{{$doc->document_id}}"
                                    >{{ utf8_encode($doc->document_id?$doc->document->name:"") }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('state_id','<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group">
                    <label>Adjuntar Archivo</label>
                    <input type="file" name="image" required>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
            </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<!-- Modal para Borrar Imagen -->

<div class="modal modal-danger fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title"><i class="fa  fa-warning"></i> Eliminar Documento</h4>
            </div>
            <div class="modal-body">
                <form action="{{ action('ProjectController@destroyfile') }}" method="post">
                        {{ csrf_field() }}
                <p id="demo"></p>
                <input id="delete_id" name="delete_id" type="hidden" value="" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-outline">Eliminar</button>
            </div>
        </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@stop

@section('js')
    <script type="text/javascript">
    $(document).ready(function ()
    { $('body').on('click', '.feed-id',function(){
        document.getElementById("delete_id").value = $(this).attr('data-id');
        document.getElementById("demo").innerHTML = 'Esta seguro de eliminar el documento: "'+$(this).attr('data-title')+'"';
        console.log($(this).attr('data-id'));
        console.log($(this).attr('data-title'));
        });
    });
    </script>
@endsection
