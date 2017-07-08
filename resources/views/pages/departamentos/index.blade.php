@extends('layouts.master')

@section('title', 'Departamentos')

@section('styles')

@stop

@section('content-header')
    <h1>
        Departamentos
        {{--<small>advanced tables</small>--}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ucwords($menu)}}</a></li>
        {{--<li><a href="#">Tables</a></li>--}}
        <li class="active">Departamentos</li>
    </ol>
@stop

@section('content-body')

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href='{{ route('mapa.departamentos.create')}}' class='btn btn-primary btn-flat pull-right'>
                        <i class='glyphicon glyphicon-plus'></i>Agregar
                    </a>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <div class="col-sm-12 no-padding-left">
                        {!! Form::open(['route' => 'mapa.departamentos.ajax', 'method' => 'post', 'id' => 'search-form']) !!}
                            <div class="col-sm-2 no-padding-left">
                                <div class="form-group">
                                    {!! Form::label('departamento', 'Departamento') !!}
                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-trash" id="borrar_departamento" title="Borrar filtro"></i>
                                        {!! Form::text('departamento', null, ['class' => 'form-control', 'id' => 'departamento']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    {!! Form::label('arovia', 'Arovia') !!}
                                    {!! Form::select('arovia', $arovia, null, ['class' => 'form-control', 'id' => 'arovia']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Departamento Nro.</th>
                            <th>Descripción</th>
                            <th>Arovia</th>
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
                            <th>Departamento Nro.</th>
                            <th>Descripción</th>
                            <th>Arovia</th>
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

    <script type="text/javascript">
        $( document ).ready(function() {

            var $input = $("#departamento");
            var $form = $("#search-form");

            $input.autocomplete(
            {
                source: '{!! route('mapa.departamentos.autocomplete') !!}',
                minLength: 1,
                select: function (event, ui) {
                    $(this).val(ui.item.label);
                    $form.submit();
                }
            });

            $input.on('keyup keypress blur change', function()
            {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#borrar_departamento').click(function()
            {
                $input.val('');
                $form.submit();
            });

            $input.on("keyup",function()
            {
                $form.submit();
            });

            $('#arovia').on('change', function()
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
                            url: '{!! route('mapa.departamentos.ajax') !!}',
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            data: function (e)
                            {
                                e.departamento = $input.val();
                                e.arovia = $('#arovia').val();
                            }
                        },
                    columns:
                        [
                            { data: 'dpto', name: 'dpto' },
                            { data: 'dpto_desc', name: 'dpto_desc' },
                            { data: 'arovia' , name: 'arovia' },
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