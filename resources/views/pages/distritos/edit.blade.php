@extends('layouts.master')

@section('title', 'Editar Distrito')

@section('styles')

@stop

@section('content-header')
    <h1>
        Editar Distrito
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        <li class="active">Distritos</li>
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
                    {!! Form::open(['route' => ['mapa.distritos.update', $data->cartodb_id], 'method' => 'post']) !!}

                        <div class="form-group">
                            {!! Form::label('the_geom', 'Geolocalización') !!}
                            {{-- {!! Form::text('the_geom', $data->the_geom, ['class' => 'form-control']) !!} --}}
                            <?php
                                $points = \Helper::getLatLong($data->the_geom);
                            ?>
                            <div class="col-xs-12 no-padding-sides">
                                <div class="col-xs-6 no-padding-left">
                                    <div class="form-group">
                                        {!! Form::label('lon', 'Longitud') !!}
                                        {!! Form::text('lon', $points->lon, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 no-padding-right">
                                    <div class="form-group">
                                        {!! Form::label('lat', 'Latitud') !!}
                                        {!! Form::text('lat', $points->lat, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('nombre_municipio', 'Nombre Municipio') !!}
                                    {!! Form::text('nombre_municipio', $data->nombre_municipio, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('fecha_creacion', 'Fecha de Creación') !!}
                                    {!! Form::text('fecha_creacion', $data->fecha_creacion, ['class' => 'form-control']) !!}
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
                                    {!! Form::label('nro_comunidades', 'Nro. de Comunidades') !!}
                                    {!! Form::text('nro_comunidades', $data->nro_comunidades, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('consejo_de_desarrollo_distrital', 'Consejo de Desarrollo Distrital') !!}
                                    {!! Form::select('consejo_de_desarrollo_distrital',
                                        ['' => 'No especificado', 'Si' => 'Si', 'No' => 'No', 'En proceso' => 'En Proceso'],
                                        $data->consejo_de_desarrollo_distrital != null ? $data->consejo_de_desarrollo_distrital : '',
                                        ['class' => 'form-control']
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('plan_de_desarrollo_distrital', 'Plan de Desarrollo Distrital') !!}
                                    {!! Form::select('plan_de_desarrollo_distrital',
                                        ['' => 'No especificado', 'Si' => 'Si', 'No' => 'No', 'En proceso' => 'En Proceso'],
                                        $data->plan_de_desarrollo_distrital != null ? $data->plan_de_desarrollo_distrital : '',
                                        ['class' => 'form-control']
                                    ) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-4 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('poblacion', 'Población') !!}
                                    {!! Form::text('poblacion', $data->poblacion, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    {!! Form::label('poblacion_rural', 'Población Rural') !!}
                                    {!! Form::text('poblacion_rural', $data->poblacion_rural, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-4 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('poblacion_urbana', 'Población Urbana') !!}
                                    {!! Form::text('poblacion_urbana', $data->poblacion_urbana, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('actividades_economicas', 'Actividades Económicas') !!}
                            {!! Form::textarea('actividades_economicas', $data->actividades_economicas, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('caracteristica_municipal', 'Característica Municipal') !!}
                            {!! Form::textarea('caracteristica_municipal', $data->caracteristica_municipal, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('temas_prioritarios_distritales', 'Temas Prioritarios Distritales') !!}
                            {!! Form::textarea('temas_prioritarios_distritales', $data->temas_prioritarios_distritales, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('enlace_nube', 'Enlace de documento') !!}
                            <div class="col-xs-12 no-padding-sides" style="margin-bottom: 15px;">
                                <div class="col-xs-11 no-padding-left">
                                    {!! Form::text('enlace_nube', $data->enlace_nube, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-1 no-padding-right">
                                    <a id="download-document" class="btn btn-default btn-flat">Bajar</a>
                                </div>
                            </div>
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
                        <a href="{{route('mapa.distritos.index')}}" class="btn btn-danger btn-flat pull-right">Cancelar</a>
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

            $('#download-document').click(function(e)
            {
                e.preventDefault();
                var url = $('input[name="enlace_nube"]').val();
                if (url != '')
                    window.open(url);
                else
                    alertify.warning('No se cargo ningún enlace de documento.');
            });
        });
    </script>

@stop