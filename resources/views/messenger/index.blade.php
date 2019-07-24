@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-md-3">
          <a href="{!! route('messages.create') !!}" class="btn btn-primary btn-block margin-bottom">Crean Mensaje</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><i class="fa fa-inbox"></i> Mensajes
                  <span class="label label-primary pull-right">12</span></a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
                <li><a href="#"><i class="fa fa-file-text-o"></i> Drafts</a></li>
                <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
                </li>
                <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Mensajes</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <!-- /.pull-right -->
              </div>
              <table id="example" class="table" style="width:100%">
                <thead>
                    <tr>
                      <th></th>
                      <th>Autor</th>
                      <th>Asunto</th>
                      <th>Mensaje</th>
                      <th>Enviado</th>
                    </tr>
                    </thead>
                <tbody>
                    @foreach($threads as $the)                       
                            <tr class="header">
                                <td><i class="fa text-yellow fa-star"></i></td>
                                <td>{!! $the->creator()->name !!}</td>
                                <td><a href="{{ route('messages.show', $the->id) }}">{{ $the->subject }}</a></td>
                                <td>{{ $the->latestMessage->body }}</td>
                            <td>{{timeago($the->created_at)}}</td>
                            </tr>                      
                    @endforeach
                </tbody>
                <tfoot>
                        
                </tfoot>
            </table>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      @php
          function timeago($date) {
	   $timestamp = strtotime($date);	
	   
	   $strTime = array("segundos", "minutos", "hora", "dia", "mes", "año");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return "Hace ".$diff . " " . $strTime[$i];
	   }
	}
      @endphp
@stop