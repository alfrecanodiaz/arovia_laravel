@extends('layouts.master')

@section('title', 'Distritos')

@section('styles')

@stop

@section('content-header')
    <h1>
        Distritos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        <li class="active">Distritos</li>
    </ol>
@stop

@section('content-body')

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href='{{ route('mapa.distritos.create')}}' class='btn btn-primary btn-flat pull-right'>
                        <i class='glyphicon glyphicon-plus'></i>Agregar
                    </a>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-12 no-padding-left">
                        {!! Form::open(['route' => 'mapa.distritos.ajax', 'method' => 'post', 'id' => 'search-form']) !!}
                            <div class="col-sm-2 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('distrito', 'Distrito') !!}
                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-trash" id="borrar_distrito" title="Borrar filtro"></i>
                                        {!! Form::text('distrito', null, ['class' => 'form-control', 'id' => 'distrito']) !!}
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::label('arovia', 'Arovia') !!}
                                    {!! Form::select('arovia', $arovia, null, ['class' => 'form-control', 'id' => 'arovia']) !!}
                                </div>
                            </div>--}}
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de creación</th>
                            <th>Nro. Comunidades</th>
                            <th>Consejo de Desarrollo Distrital</th>
                            <th>Plan de Desarrollo Distrital</th>
                            <th data-sortable="false">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de creación</th>
                            <th>Nro. Comunidades</th>
                            <th>Consejo de Desarrollo Distrital</th>
                            <th>Plan de Desarrollo Distrital</th>
                            <th data-sortable="false">Acciones</th>
                        </tr>
                        </tfoot>
                    </table>
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

    @include('partials.global-scripts')

    <script type="text/javascript">
        $( document ).ready(function() {

            var $input = $("#distrito");
            var $form = $("#search-form");

            $input.autocomplete(
            {
                source: '{!! route('mapa.distritos.autocomplete') !!}',
                minLength: 1,
                select: function (event, ui) {
                    $(this).val(ui.item.label);
                    $form.submit();
                }
            });

            $input.on('keyup keypress blur change', function()
            {
                this.value = capitalizeFirstLetter(this.value);
            });

            $('#borrar_distrito').click(function()
            {
                $input.val('');
                $form.submit();
            });

            $input.on("keyup",function()
            {
                $form.submit();
            });

            /*$('#arovia').on('change', function()
            {
                $form.submit();
            });*/

            $form.on('submit', function(e)
            {
                table.draw();
                e.preventDefault();
            });

            var table = $('.datatable').DataTable(
                {
                    dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                    "<'row'<'col-xs-12't>>"+
                    "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                    "deferRender": true,
                    processing: false,
                    serverSide: true,
                    "paginate": true,
                    "lengthChange": true,
                    "filter": true,
                    "sort": true,
                    "info": true,
                    "autoWidth": true,
                    ajax:
                        {
                            url: '{!! route('mapa.distritos.ajax') !!}',
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            data: function (e)
                            {
                                e.distrito = $input.val();
//                                e.arovia = $('#arovia').val();
                            }
                        },
                    columns:
                        [
                            { data: 'nombre_municipio', name: 'nombre_municipio' },
                            { data: 'fecha_creacion', name: 'fecha_creacion' },
                            { data: 'nro_comunidades' , name: 'nro_comunidades' },
                            { data: 'consejo_de_desarrollo_distrital' , name: 'consejo_de_desarrollo_distrital' },
                            { data: 'plan_de_desarrollo_distrital' , name: 'plan_de_desarrollo_distrital' },
                            { data: 'action', name: 'action', orderable: false, searchable: false}
                        ],
                    language: {
                        processing:     "Procesando...",
                        search:         "Buscar",
                        lengthMenu:     "Mostrar _MENU_ Elementos",
                        info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
                        infoFiltered:   ".",
                        infoPostFix:    "",
                        loadingRecords: "Cargando Registros...",
                        zeroRecords:    "No existen registros disponibles",
                        emptyTable:     "No existen registros disponibles",
                        paginate: {
                            first:      "Primera",
                            previous:   "Anterior",
                            next:       "Siguiente",
                            last:       "Ultima"
                        }
                    }
                });
        });
    </script>

@stop