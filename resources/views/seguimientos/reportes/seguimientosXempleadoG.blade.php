@extends('plantillas.admin_template')

@include('seguimientos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('seguimientos.index') }}">@yield('seguimientosAppTitle')</a></li>
	    <li class="active">Reporte de Seguimientos por Empleado para Planteles</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('seguimientosAppTitle') / Reporte de Seguimientos por Empleado para Planteles </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'seguimientos.seguimientosXempleadoGr')) !!}

                <div class="form-group col-md-6 @if($errors->has('fecha_f')) has-error @endif">
                    <label for="fecha_f-field">Fecha de:</label>
                    {!! Form::text("fecha_f", null, array("class" => "form-control", "id" => "fecha_f-field")) !!}
                    @if($errors->has("fecha_f"))
                    <span class="help-block">{{ $errors->first("fecha_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('fecha_t')) has-error @endif">
                    <label for="fecha_t-field">Fecha a:</label>
                    {!! Form::text("fecha_t", null, array("class" => "form-control", "id" => "fecha_t-field")) !!}
                    @if($errors->has("fecha_t"))
                    <span class="help-block">{{ $errors->first("fecha_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('plantel_f')) has-error @endif">
                    <label for="plantel_f-field">Plantel de:</label>
                    {!! Form::select("plantel_f", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_f-field")) !!}
                    @if($errors->has("plantel_f"))
                    <span class="help-block">{{ $errors->first("plantel_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('plantel_t')) has-error @endif">
                    <label for="plantel_t-field">Plantel a:</label>
                    {!! Form::select("plantel_t", $list["Plantel"], null, array("class" => "form-control", "id" => "plantel_t-field")) !!}
                    @if($errors->has("plantel_t"))
                    <span class="help-block">{{ $errors->first("plantel_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('empleado_f')) has-error @endif">
                    <label for="empleado_f-field">Empleado de:</label>
                    {!! Form::select("empleado_f", $list["Empleado"], null, array("class" => "form-control", "id" => "empleado_f-field")) !!}
                    @if($errors->has("empleado_f"))
                    <span class="help-block">{{ $errors->first("empleado_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('empleado_t')) has-error @endif">
                    <label for="empleado_t-field">Empleado a:</label>
                    {!! Form::select("empleado_t", $list["Empleado"], null, array("class" => "form-control", "id" => "empleado_t-field")) !!}
                    @if($errors->has("empleado_t"))
                    <span class="help-block">{{ $errors->first("empleado_t") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('estatus_f')) has-error @endif">
                    <label for="estatus_f-field">Estatus de:</label>
                    {!! Form::select("estatus_f", $list1["StSeguimiento"], null, array("class" => "form-control", "id" => "estatus_f-field")) !!}
                    @if($errors->has("estatus_f"))
                    <span class="help-block">{{ $errors->first("estatus_f") }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6 @if($errors->has('estatus_t')) has-error @endif">
                    <label for="estatus_t-field">Estatus de:</label>
                    {!! Form::select("estatus_t", $list1["StSeguimiento"], null, array("class" => "form-control", "id" => "estatus_t-field")) !!}
                    @if($errors->has("estatus_t"))
                    <span class="help-block">{{ $errors->first("estatus_t") }}</span>
                    @endif
                </div>
                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Crear Reporte</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
    $('#fecha_f-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
      $('#fecha_t-field').Zebra_DatePicker({
        days:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
        months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        readonly_element: false,
        lang_clear_date: 'Limpiar',
        show_select_today: 'Hoy',
      });
    });
    
    </script>
@endpush