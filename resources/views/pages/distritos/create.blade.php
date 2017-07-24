@extends('layouts.master')

@section('title', 'Crear Distrito')

@section('styles')

@stop

@section('content-header')
    <h1>
        Crear Distrito
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
                    {!! Form::open(['route' => 'mapa.distritos.store', 'method' => 'post', 'id' => 'create-form']) !!}

                        <div class="form-group">
                            {!! Form::label('the_geom', 'Geolocalización') !!}
                            {{-- {!! Form::text('the_geom', null, ['class' => 'form-control']) !!} --}}
                            <div class="col-xs-12 no-padding-sides">
                                <div class="col-xs-6 no-padding-left">
                                    <div class="form-group">
                                        {!! Form::label('lon', 'Longitud') !!}
                                        {!! Form::text('lon', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-6 no-padding-right">
                                    <div class="form-group">
                                        {!! Form::label('lat', 'Latitud') !!}
                                        {!! Form::text('lat', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('nombre_municipio', 'Nombre Municipio') !!}
                                    {!! Form::text('nombre_municipio', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('fecha_creacion', 'Fecha de Creación') !!}
                                    {!! Form::text('fecha_creacion', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('superficie', 'Superficie') !!}
                                    {!! Form::text('superficie', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('nro_comunidades', 'Nro. de Comunidades') !!}
                                    {!! Form::text('nro_comunidades', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-6 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('consejo_de_desarrollo_distrital', 'Consejo de Desarrollo Distrital') !!}
                                    {!! Form::select('consejo_de_desarrollo_distrital',
                                        ['' => 'No especificado', 'Si' => 'Si', 'No' => 'No', 'En proceso' => 'En Proceso'],
                                        null,
                                        ['class' => 'form-control']
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('plan_de_desarrollo_distrital', 'Plan de Desarrollo Distrital') !!}
                                    {!! Form::select('plan_de_desarrollo_distrital',
                                        ['' => 'No especificado', 'Si' => 'Si', 'No' => 'No', 'En proceso' => 'En Proceso'],
                                        null,
                                        ['class' => 'form-control']
                                    ) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding-sides">
                            <div class="col-xs-4 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('poblacion', 'Población') !!}
                                    {!! Form::text('poblacion', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    {!! Form::label('poblacion_rural', 'Población Rural') !!}
                                    {!! Form::text('poblacion_rural', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-4 no-padding-right">
                                <div class="form-group">
                                    {!! Form::label('poblacion_urbana', 'Población Urbana') !!}
                                    {!! Form::text('poblacion_urbana', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('actividades_economicas', 'Actividades Económicas') !!}
                            {!! Form::textarea('actividades_economicas', null, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('caracteristica_municipal', 'Característica Municipal') !!}
                            {!! Form::textarea('caracteristica_municipal', null, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('temas_prioritarios_distritales', 'Temas Prioritarios Distritales') !!}
                            {!! Form::textarea('temas_prioritarios_distritales', null, 
                            ['class' => 'form-control', 'size' => '20x5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('enlace_nube', 'Enlace de documento') !!}
                            <div class="col-xs-12 no-padding-sides" style="margin-bottom: 15px;">
                                <div class="col-xs-11 no-padding-left">
                                    {!! Form::text('enlace_nube', null, ['class' => 'form-control']) !!}
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
                                    <img src="" class="img-fluid">
                                </div>
                                <div class="col-xs-5">
                                    {!! Form::text('_url', null, ['class' => 'form-control']) !!}
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

            $('#create-form').submit(function ()
            {
                $(this).children(':input[value=""]').attr("disabled", "disabled");
                return true;
            });
        });
    </script>

@stop