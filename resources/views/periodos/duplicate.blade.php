@extends('plantillas.admin_template')

@include('periodos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('periodos.index') }}">@yield('periodosAppTitle')</a></li>
	    <li class="active">Duplicar</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('periodosAppTitle') / Duplicar {{$periodo->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($periodo, array('route' => array('periodos.store'))) !!}

@include('periodos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Duplicar</button>
                    <a class="btn btn-link pull-right" href="{{ route('periodos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection