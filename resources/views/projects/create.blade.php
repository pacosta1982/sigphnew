@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
<li><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
<li class="active"><a href="#">Crear Proyecto</a></li>
</ol>
@stop

@section('content')

<div class="box box-primary">
    <form role="form" action="{{isset($project['id'])?action('ProjectController@update',['id' => $project['id']]):action('ProjectController@store') }}" method="post">
            @csrf
            @if(isset($project['id']))
                {!! method_field('patch') !!}
            @endif
      <div class="box-body">
          <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label>Nombre del Proyecto</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name',isset($project['name'])?$project['name']:'') }}"  placeholder="Ingrese Nombre del Proyecto">
                        {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('leader_name') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Nombre del Lider del Grupo</label>
                        <input type="text" class="form-control" name="leader_name" value="{{ old('leader_name',isset($project['leader_name'])?$project['leader_name']:'') }}" placeholder="Ingrese Nombre del Lider del Grupo">
                        {!! $errors->first('leader_name','<span class="help-block">:message</span>') !!}
                    </div>



                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('sat_id') ? 'has-error' : '' }}">
                        <label>SAT</label>
                        <input type="hidden" name="sat_id" value="{{ $user->sat_ruc }}">
                        <input type="text" class="form-control" value="{{ $user->sat_ruc?$user->getSat->NucNomSat:"" }}" readonly>
                        {!! $errors->first('sat_id','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone',isset($project['phone'])?$project['phone']:'') }}" placeholder="Ingrese Telefono de Contacto">
                        {!! $errors->first('phone','<span class="help-block">:message</span>') !!}
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
                            @foreach($tierra as $key=>$name)
                                <option value="{{$name->id}}"
                                    {{ old('land_id',isset($project['land_id'])?$project['land_id']:'') == $name->id ? 'selected' : '' }}
                                    >{{ $name->name }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('land_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('land_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Tipologia</label>
                    <select class="form-control required" name="land_id">
                        <option value="">Selecciona la Tipologia</option>
                            @foreach($tierra as $key=>$name)
                                <option value="{{$name->id}}"
                                    {{ old('land_id',isset($project['land_id'])?$project['land_id']:'') == $name->id ? 'selected' : '' }}
                                    >{{ $name->name }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('land_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Departamento</label>
                    <select class="form-control required" name="state_id">
                        <option value="">Selecciona el Departamento</option>
                            @foreach($departamentos as $key=>$dpto)
                                <option value="{{$dpto->DptoId}}"
                                    {{ old('state_id',isset($project['state_id'])?$project['state_id']:'') == $dpto->DptoId ? 'selected' : '' }}
                                    >{{ $dpto->DptoNom }}</option>
                            @endforeach
                    </select>
                    {!! $errors->first('state_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('city_id') ? 'has-error' : '' }}">
                    <label for="exampleInputPassword1">Distrito</label>
                    <select class="form-control required" name="city_id">
                        <option value="">Selecciona un Distrito</option>
                        @if(isset($cities))
                            @foreach($cities as $key=>$city)
                                <option value="{{$key}}" {{ old('city_id',isset($project['city_id'])?$project['city_id']:'') == $key ? "selected":"" }}>{{ $city }}</option>
                            @endforeach
                        @endif
                    </select>
                    {!! $errors->first('city_id','<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('localidad') ? 'has-error' : '' }}">
                    <label>Localidad</label>
                    <input type="text" class="form-control" name="localidad" value="{{ old('localidad',isset($project['localidad'])?$project['localidad']:'') }}"  placeholder="Ingrese Localidad">
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
    $('select[name="state_id"]').on('change', function() {
                var stateID = $(this).val();
                if(stateID) {
                    $.ajax({
                        url: '{{URL::to('/projects')}}/ajax/'+stateID+"/cities",
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            $('select[name="city_id"]').empty();
                            $('select[name="city_id"]').append('<option value="">Selecciona un Distrito</option>');

                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });

                        }
                    });
                }else{
                    $('select[name="city_id"]').empty();
                }
            });
    </script>
@stop
