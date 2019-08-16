<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-miembro">
    <i class="fa fa-plus-circle"></i> Nuevo Miembro
</button>
<br>
<br>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <tbody>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th class="text-center">Cédula</th>
              <th class="text-center">Edad</th>
              <th>Parentesco</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Acciones</th>
            </tr>
            @foreach($miembros as $key=>$mi)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{ $mi->miembro_id?$mi->getPostulante->first_name:"" }} {{ $mi->miembro_id?$mi->getPostulante->last_name:"" }}</td>
              <td class="text-center">{{ number_format($mi->miembro_id?$mi->getPostulante->cedula:"",0,".",".") }} </td>
              <td class="text-center">{{ \Carbon\Carbon::parse( $mi->postulante_id?$mi->getPostulante->birthdate:"")->age }} </td>
              <td>{{ $mi->miembro_id?$mi->getParentesco->name:"" }}</td>
              <td class="text-center">{{ number_format($mi->miembro_id?$mi->getPostulante->ingreso:"",0,".",".") }} </td>
              <td class="text-center">
                    <div class="btn-group">
                            <button type="button" class="btn btn-info">Acciones</button>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="{!! action('PostulantesController@editmiembro', ['id'=>$project->id,'idpostulantes'=>$mi->postulante_id?$mi->getPostulante->id:""]) !!}">Editar</a></li>
                              <li><a href="#">Eliminar</a></li>
                            </ul>
                          </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>
        <br>
    </div>
  </div>

<div class="modal fade" id="modal-miembro" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Ingrese Número de Cédula</h4>
        </div>
        <div class="modal-body">
            <form action="{{ action('PostulantesController@createmiembro', ['id' => $project->id ]) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                    <input type="text" name="postulante_id" value="{{$postulante->id}}" hidden>
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
