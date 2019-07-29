@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
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
          <h3 class="box-title">Postulantes</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tbody><tr>
              <th style="width: 10px">#</th>
              <th>Task</th>
              <th>Progress</th>
              <th style="width: 40px">Label</th>
            </tr>
            <tr>
              <td>1.</td>
              <td>Update software</td>
              <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                </div>
              </td>
              <td><span class="badge bg-red">55%</span></td>
            </tr>
            <tr>
              <td>2.</td>
              <td>Clean database</td>
              <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                </div>
              </td>
              <td><span class="badge bg-yellow">70%</span></td>
            </tr>
            <tr>
              <td>3.</td>
              <td>Cron job running</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                </div>
              </td>
              <td><span class="badge bg-light-blue">30%</span></td>
            </tr>
            <tr>
              <td>4.</td>
              <td>Fix and squish bugs</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                </div>
              </td>
              <td><span class="badge bg-green">90%</span></td>
            </tr>
          </tbody></table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <ul class="pagination pagination-sm no-margin pull-right">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">»</a></li>
          </ul>
        </div>
      </div>

    </div>

  </div>

@stop
