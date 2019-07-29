@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>{{ $title }}</h1>
<ol class="breadcrumb">
    <li class="active"><a href="{{url('projects')}}"><i class="fa fa-home"></i>Inicio</a></li>
  </ol>
@stop

@section('content')


@stop
