@extends('layouts.master')

@section('title', 'Home')

@section('styles')

@stop

@section('content')

    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">Bootstrap dataTables</div>
        </div>
        <div class="panel-body table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Localización</th>
                    <th>Arovia</th>
                    <th>Departamento Nro.</th>
                    <th>Descripción</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>First</td>
                        <td>Second</td>
                        <td>Third</td>
                        <td>Fourth</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('scripts')

@stop