@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
<li><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
<li class="active"><a href="#">Agregar Postulante</a></li>
</ol>
@stop

@section('content')

<div class="box box-primary">
    <form role="form" action="{{isset($project['id'])?action('PostulantesController@update',['id' => $project['id']]):action('PostulantesController@storemiembro') }}" method="post">
            @csrf
            @if(isset($project['id']))
                {!! method_field('patch') !!}
            @endif
            <input type="text"  name="gender" value="{{ $sexo }}"  hidden>
            <input type="text"  name="project_id" value="{{ $project_id->id }}"  hidden>
            <input type="text"  name="grupo" value="{{ $project_id->name }}"  hidden>
            <input type="text"  name="postulante_id" value="{{ $postulante }}"  hidden>

      <div class="box-body">
          <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        <label>Nombres</label>
                        <input type="text" class="form-control" name="first_name" value="{{ $nombre }}"  readonly>
                        {!! $errors->first('first_name','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('cedula') ? 'has-error' : '' }}">
                        <label>Cedula</label>
                        <input type="text" class="form-control" name="cedula" value="{{ $cedula }}"  readonly>
                        {!! $errors->first('cedula','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('nacionalidad') ? 'has-error' : '' }}">
                        <label>Nacionalidad</label>
                        <input type="text" class="form-control" name="nacionalidad" value="{{ $nac }}"  readonly>
                        {!! $errors->first('nacionalidad','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('localidad') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Localidad</label>
                        <input type="text" class="form-control" required name="localidad" value="{{ old('localidad',isset($project['localidad'])?$project['localidad']:'') }}" placeholder="Ingrese Localidad">
                        {!! $errors->first('localidad','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Dirección</label>
                        <input type="text" required class="form-control" name="address" value="{{ old('localidad',isset($project['localidad'])?$project['localidad']:'') }}" placeholder="Ingrese Dirección">
                        {!! $errors->first('address','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Telefono (Linea Baja)</label>
                        <input type="text" required class="form-control" name="phone" value="{{ old('phone',isset($project['phone'])?$project['phone']:'') }}" placeholder="Ingrese telefono">
                        {!! $errors->first('phone','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Parentesco</label>
                        <select class="form-control required" name="parentesco_id" required>
                            <option value="">Seleccione Parentesco</option>
                            @foreach($parentesco as $key=>$par)
                                <option value="{{$par->id}}"
                                    {{ old('typology_id',isset($project['typology_id'])?$project['typology_id']:'') == $par->id ? 'selected' : '' }}
                                    >{{ $par->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" name="last_name" value="{{ $apellido }}"  readonly>
                        {!! $errors->first('last_name','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('marital_status') ? 'has-error' : '' }}">
                        <label>Estado Civil</label>
                        <input type="text" class="form-control" name="marital_status" value="{{ $est }}"  readonly>
                        {!! $errors->first('marital_status','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
                        <label>Fecha de Nacimiento</label>
                        <input type="text" class="form-control" name="birthdate" value="{{ $fecha }}"  readonly>
                        {!! $errors->first('birthdate','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('asentamiento') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Asentamiento</label>
                        <input type="text" class="form-control" name="asentamiento" value="{{ old('asentamiento',isset($project['asentamiento'])?$project['asentamiento']:'') }}" placeholder="Ingrese Asentamiento">
                        {!! $errors->first('asentamiento','<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('asentamiento') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Ingreso Mensual</label>
                        <input type="text" class="form-control" required name="ingreso" value="{{ old('ingreso',isset($project['ingreso'])?$project['ingreso']:'') }}" placeholder="Ingrese el Ingreso Mensual">
                        {!! $errors->first('ingreso','<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Telefono Movil (Celular)</label>
                        <input type="text" class="form-control" required name="mobile" value="{{ old('mobile',isset($project['mobile'])?$project['mobile']:'') }}" placeholder="Ingrese Telefono Movil (Celular)">
                        {!! $errors->first('mobile','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('land_id') ? 'has-error' : '' }}">
                        <label for="exampleInputPassword1">Discapacidad</label>
                        <select class="form-control required" name="discapacidad_id" required>
                            <option value="">Selecciona la Discapacidad</option>
                                @foreach($discapacdad as $key=>$dis)
                                    <option value="{{$dis->id}}"
                                        {{ old('typology_id',isset($project['typology_id'])?$project['typology_id']:'') == $dis->id ? 'selected' : '' }}
                                        >{{ $dis->name }}</option>
                                @endforeach
                        </select>
                        {!! $errors->first('typology_id','<span class="help-block">:message</span>') !!}
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
