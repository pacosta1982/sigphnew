@extends('adminlte::page')

@section('title', 'FONAVIS')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
<li><a href="{{url('actualizacion')}}"><i class="fa fa-home"></i>Inicio</a></li>
<li class="active"><a href="#">Crear Proyecto de Actualización</a></li>
</ol>
@stop

@section('content')

<div class="box box-primary">
    <form role="form" action="{{isset($project['id'])?action('ActualizacionController@update',['id' => $project['id']]):action('ActualizacionController@store') }}" method="post">
            @csrf
            @if(isset($project['id']))
                {!! method_field('patch') !!}
            @endif
            <input type="text" name="action" value="update" hidden>
      <div class="box-body">
          <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label>Nombre del Proyecto</label>
                        <input type="text" required class="form-control" name="name" value="{{ old('name',isset($project['name'])?utf8_decode($project['name']):'') }}"  placeholder="Ingrese Nombre del Proyecto">
                        {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('leader_name') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Nombre del Lider del Grupo</label>
                        <input required type="text" class="form-control" name="leader_name" value="{{ old('leader_name',isset($project['leader_name'])?$project['leader_name']:'') }}" placeholder="Ingrese Nombre del Lider del Grupo">
                        {!! $errors->first('leader_name','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('leader_name') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Expediente Social</label>
                        <input required type="text" class="form-control" name="expsocial" value="{{ old('expsocial',isset($project['expsocial'])?$project['expsocial']:'') }}" placeholder="Ingrese Numero de Expediente Social">
                        {!! $errors->first('expsocial','<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('sat_id') ? 'has-error' : '' }}">
                        <label>SAT</label>
                        <input type="hidden" name="sat_id" value="{{ $user->sat_ruc }}">
                        <input type="text" class="form-control" value="{{ utf8_encode($user->sat_ruc?$user->getSat->NucNomSat:"") }}" readonly>
                        {!! $errors->first('sat_id','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input required type="number" class="form-control" name="phone" value="{{ old('phone',isset($project['phone'])?$project['phone']:'') }}" placeholder="Ingrese Telefono de Contacto">
                        {!! $errors->first('phone','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('exptecnico') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Expediente Social</label>
                        <input required type="text" class="form-control" name="exptecnico" value="{{ old('exptecnico',isset($project['exptecnico'])?$project['exptecnico']:'') }}" placeholder="Ingrese Numero de Expediente Técnico">
                        {!! $errors->first('exptecnico','<span class="help-block">:message</span>') !!}
                    </div>
                </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('modalidad_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Modalidad</label>
                    <select class="form-control required" name="modalidad_id">
                        <option value="">Selecciona la Modalidad</option>
                            @foreach($modalidad as $key=>$mod)
                                <option value="{{$mod->id}}"
                                    {{ old('modalidad_id',isset($project['modalidad_id'])?$project['modalidad_id']:'') == $mod->id ? 'selected' : '' }}
                                    >{{ $mod->name }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('modalidad_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('land_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Tipo Terreno</label>
                    <select class="form-control required" name="land_id">
                        <option value="">Selecciona el tipo de Terreno</option>
                        @if(isset($lands))
                            @foreach($tierra as $key=>$name)
                                <option value="{{$name->id}}"
                                    {{ old('land_id',isset($project['land_id'])?$project['land_id']:'') == $name->id ? 'selected' : '' }}
                                    >{{ $name->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    {!! $errors->first('land_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('land_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Tipologia</label>
                    <select class="form-control required" name="typology_id">
                        <option value="">Selecciona la Tipologia</option>
                        @if(isset($typology))
                            @foreach($tipologias as $key=>$tipo)
                                <option value="{{$tipo->id}}"
                                    {{ old('typology_id',isset($project['typology_id'])?$project['typology_id']:'') == $tipo->id ? 'selected' : '' }}
                                    >{{ $tipo->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    {!! $errors->first('typology_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Departamento</label>
                    <select class="form-control required" name="state_id" required>
                        <option value="">Selecciona el Departamento</option>
                            @foreach($departamentos as $key=>$dpto)
                                <option value="{{$dpto->DptoId}}"
                                    {{ old('state_id',isset($project['state_id'])?$project['state_id']:'') == $dpto->DptoId ? 'selected' : '' }}
                                    >{{ utf8_encode($dpto->DptoNom) }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('state_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Distrito</label>
                    <input required type="text" class="form-control" name="city_id" value="{{ old('city_id',isset($project['city_id'])?utf8_encode($project['city_id']):'') }}" placeholder="Ingrese Distrito">
                    {!! $errors->first('city_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('localidad') ? 'has-error' : '' }}">
                    <label>Localidad</label>
                    <input type="text" required class="form-control" name="localidad" value="{{ old('localidad',isset($project['localidad'])?utf8_encode($project['localidad']):'') }}"  placeholder="Ingrese Localidad">
                    {!! $errors->first('localidad','<span class="help-block">:message</span>') !!}
                </div>
              </div>
          </div>
          <button type="submit" class="btn btn-primary pull-right">Guardar</button>
      </div>
    </form>
  </div>

@stop
@section('js')

    <script type="text/javascript">

            $('select[name="modalidad_id"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '{{URL::to('/projects')}}/ajax/'+stateID+"/lands",
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('select[name="land_id"]').empty();
                            $('select[name="land_id"]').append('<option value="">Selecciona el Tipo de Terreno</option>');

                            $.each(data, function(key, value) {
                                $('select[name="land_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });

                        }
                    });
                }else{
                    $('select[name="land_id"]').empty();
                }
            });

            $('select[name="land_id"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '{{URL::to('/projects')}}/ajax/'+stateID+"/typology",
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('select[name="typology_id"]').empty();
                            $('select[name="typology_id"]').append('<option value="">Selecciona la Modalidad</option>');

                            $.each(data, function(key, value) {
                                $('select[name="typology_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });

                        }
                    });
                }else{
                    $('select[name="typology_id"]').empty();
                }
            });

            function encode_utf8( s )
            {
            return unescape( encodeURIComponent( s ) );
            }

            function decode_utf8( s )
            {
            return decodeURIComponent( escape( s ) );
            }
    </script>
@stop
