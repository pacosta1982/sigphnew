@extends('adminlte::page')

@section('content')
<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Crear Nuevo Mensaje</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{ route('messages.store') }}" method="post">
                {{ csrf_field() }}
          <div class="box-body">
            
                <div class="form-group">
                        <label class="control-label">Asunto</label>
                        <input type="text" class="form-control" name="subject" placeholder="Subject"
                               value="{{ old('subject') }}">
                    </div>
        
                    <!-- Message Form Input -->
                    <div class="form-group">
                        <label class="control-label">Mensaje</label>
                        <textarea name="message" class="form-control">{{ old('message') }}</textarea>
                    </div>
        
                    @if($users->count() > 0)
                        <div class="checkbox">
                            @foreach($users as $user)
                                <label title="{{ $user->name }}"><input type="checkbox" name="recipients[]"
                                                                        value="{{ $user->id }}">{!!$user->name!!}</label>
                            @endforeach
                        </div>
                    @endif
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
      </div>
    
@stop