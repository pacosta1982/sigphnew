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

    <!-- /.box-header -->
    <!-- form start -->
    <form role="form">
      <div class="box-body">
          <div class="col-md-6">
                <div class="form-group">
                        <label>Nombre del Proyecto</label>
                        <input type="text" class="form-control" name="name"  placeholder="Ingrese Nombre del Proyecto">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input type="text" class="form-control" name="phone" placeholder="Ingrese Telefono de Contacto">
                      </div>
                      <div class="form-group">
                            <label for="exampleInputPassword1">Departamento</label>
                            <select class="form-control required" name="state_id">
                                <option value="">Selecciona el Departamento</option>
                                    @foreach($departamentos as $key=>$dpto)
                                        <option value="{{$dpto->DptoId}}">{{ $dpto->DptoNom }}</option>
                                    @endforeach
                            </select>
                          </div>
          </div>

          <div class="col-md-6">
                <div class="form-group">
                    <label>SAT</label>
                    <input type="hidden" name="sat_id" value="{{ $user->sat_ruc }}">
                    <input type="text" class="form-control" value="{{ $user->sat_ruc?$user->getSat->NucNomSat:"" }}" readonly>
                </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Tipo Terreno</label>
                        <select class="form-control required" name="land_id">
                            <option value="">Selecciona el tipo de Terreno</option>
                                @foreach($tierra as $key=>$name)
                                    <option value="{{$name->id}}">{{ $name->name }}</option>
                                @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                            <label for="exampleInputPassword1">Distrito</label>
                            <select class="form-control required" name="city_id">
                                <option value="">Selecciona un Distrito</option>
                            </select>
                          </div>
                      <button type="submit" class="btn btn-primary pull-right">Submit</button>
          </div>



      </div>
      <!-- /.box-body -->

    </form>
  </div>

@stop
@section('js')
    <script> console.log('Hi!'); </script>
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
