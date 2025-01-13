@extends('admin')
{{-- @section('breadcrumbs')
{!! Breadcrumbs::render($breadcrumb, @$item) !!}
@endsection --}}

@section('title', 'Доступы пользователей')
@section('content_header')
<h1>Доступы пользователей</h1>
@stop
@section('content')
<a class="btn btn-primary" href="{{ route('admin.rap.permissions.create') }}" role="button"> Создание доступа </a>

<table id="table" data-toggle="table" data-toolbar="#toolbar" data-show-fullscreen="true" data-cache="false"
    data-locale="ru-RU" data-cookie="true" data-search="true" data-show-refresh="true"
    data-show-search-clear-button="true" data-url="/api/v1/admin/permissions" data-data-field="items"
    data-side-pagination="server" data-pagination="true" data-page-list="[10, 25, 50 ]">
    <thead>
        <tr>
            <th data-checkbox="true"></th>
            <th data-field="id" data-switchable="false">№</th>
            <th data-field="name" data-sortable="true">Наименование </th>
            <th data-field="guard_name" data-sortable="true">Guard Name </th>
            <th data-formatter="nameFormatter" data-switchable="false">Д</th>
        </tr>
    </thead>
</table>

@endsection



@push('js')



<link href="{{ asset('js/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/bootstrap-table/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table/extensions/group-by-v2/bootstrap-table-group-by.min.js') }}"></script>



<script>
    function nameFormatter(value, row) {

        return '<div class="btn-group" role="group" aria-label="Basic example"><a class="btn btn-primary  btn-sm" href="' +
            row.edit_link +
            '" title="Редактировать" target="_blank"><i class="fas fa-edit"></i> </a>   </div>'
    }
    $(document).ready(function() {

        var $table = $('#table')

    })
</script>
@endpush
