@extends('layouts.master')

@section('title', 'Asentamientos')

@section('styles')

@stop

@section('content-header')
    <h1>
        Asentamientos
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        <li class="active">Asentamientos</li>
    </ol>
@stop

@section('content-body')

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href='{{ route('mapa.asentamientos.create')}}' class='btn btn-primary btn-flat pull-right'>
                        <i class='glyphicon glyphicon-plus'></i>Agregar
                    </a>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-12 no-padding-left">
                        {!! Form::open(['route' => 'mapa.asentamientos.ajax', 'method' => 'post', 'id' => 'search-form']) !!}
                            <div class="col-sm-2 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('asentamiento', 'Asentamiento') !!}
                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-trash" id="borrar_asentamiento" title="Borrar filtro"></i>
                                        {!! Form::text('asentamiento', null, ['class' => 'form-control', 'id' => 'asentamiento']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de creación</th>
                            <th>Población</th>
                            <th>Superficie</th>
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
                            <th>Población</th>
                            <th>Superficie</th>
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

            var $input = $("#asentamiento");
            var $form = $("#search-form");

            $input.autocomplete(
            {
                source: '{!! route('mapa.asentamientos.autocomplete') !!}',
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

            $('#borrar_asentamiento').click(function()
            {
                $input.val('');
                $form.submit();
            });

            $input.on("keyup",function()
            {
                $form.submit();
            });

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
                            url: '{!! route('mapa.asentamientos.ajax') !!}',
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            data: function (e)
                            {
                                e.asentamiento = $input.val();
                            }
                        },
                    columns:
                        [
                            { data: 'nombre', name: 'nombre' },
                            { data: 'fecha_de_creacion', name: 'fecha_de_creacion' },
                            { data: 'poblacion' , name: 'poblacion' },
                            { data: 'superficie' , name: 'superficie' },
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