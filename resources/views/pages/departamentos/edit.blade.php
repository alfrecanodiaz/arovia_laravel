@extends('layouts.master')

@section('title', 'Editar Departamento')

@section('styles')

@stop

@section('content-header')
    <h1>
        Editar Departamento
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        <li class="active">Departamentos</li>
    </ol>
@stop

@section('content-body')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                {{--<div class="box-header">
                </div>--}}
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['route' => ['mapa.departamentos.update', $data->cartodb_id], 'method' => 'post']) !!}
                        <div class="form-group">
                            {!! Form::label('the_geom', 'Geolocalización') !!}
                            {!! Form::text('the_geom', $data->the_geom, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('dpto', 'Departamento Nro.') !!}
                            {!! Form::text('dpto', $data->dpto, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('dpto_desc', 'Descripción') !!}
                            {!! Form::text('dpto_desc', $data->dpto_desc, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('arovia', 'Arovia') !!}
                            {!! Form::select('arovia',
                                ['' => 'No especificado', 'si' => 'Si', 'no' => 'No'],
                                $data->arovia != null ? $data->arovia : '',
                                ['class' => 'form-control']
                            ) !!}
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat pull-left">Actualizar</button>
                        <a href="{{route('mapa.departamentos.index')}}" class="btn btn-danger btn-flat pull-right">Cancelar</a>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@stop

@section('scripts')

    <script type="text/javascript">
        $( document ).ready(function() {

        });
    </script>

@stop