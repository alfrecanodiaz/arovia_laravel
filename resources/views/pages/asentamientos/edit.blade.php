@extends('layouts.master')

@section('title', 'Editar Asentamiento')

@section('styles')

@stop

@section('content-header')
    <h1>
        Editar Asentamiento
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        <li class="active">Asentamientos</li>
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
                    {!! Form::open(['route' => ['mapa.asentamientos.update', $data->cartodb_id], 'method' => 'post']) !!}

                        <div class="form-group">
                            {!! Form::label('the_geom', 'Geolocalización') !!}
                            {!! Form::text('the_geom', $data->the_geom, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('nombre', 'Nombre de Asentamiento') !!}
                                    {!! Form::text('nombre', $data->nombre, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('fecha_de_creacion', 'Fecha de Creación') !!}
                                    {!! Form::text('fecha_de_creacion', $data->fecha_de_creacion, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('superficie', 'Superficie') !!}
                                    {!! Form::text('superficie', $data->superficie, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('poblacion', 'Población') !!}
                                    {!! Form::text('poblacion', $data->poblacion, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('caracteristicas', 'Características') !!}
                            {!! Form::textarea('caracteristicas', $data->caracteristicas, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('origen_asentamiento', 'Origen del Asentamiento') !!}
                            {!! Form::textarea('origen_asentamiento', $data->origen_asentamiento, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('dedicacion_de_la_comunidad', 'Dedicación de la Comunidad') !!}
                            {!! Form::textarea('dedicacion_de_la_comunidad', $data->dedicacion_de_la_comunidad, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('infraestrucutra_local', 'Infraestructura Local') !!}
                            {!! Form::textarea('infraestrucutra_local', $data->infraestrucutra_local, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('_url', 'Enlace de imagen') !!}
                            <div class="col-xs-12 no-padding-sides img-container">
                                <div class="col-xs-6 no-padding-left">
                                    <img src="{{ $data->_url }}" class="img-fluid">
                                </div>
                                <div class="col-xs-5">
                                    {!! Form::text('_url', $data->_url, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-1 no-padding-right">
                                    <a id="apply-src" class="btn btn-default btn-flat">Aplicar</a>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-flat pull-left">Actualizar</button>
                        <a href="{{route('mapa.asentamientos.index')}}" class="btn btn-danger btn-flat pull-right">Cancelar</a>
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
        $( document ).ready(function()
        {
            $('#apply-src').click(function ()
            {
                var src = $('input[name="_url"]').val();
                if (src != '')
                    $('.img-container').find('img').attr('src', src);
                else
                    alertify.warning('No se cargo ningún enlace de imagen.');
            });
        });
    </script>

@stop