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

@stop
