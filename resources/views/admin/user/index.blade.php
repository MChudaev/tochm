@extends('admin')

{{-- @section('breadcrumbs')
{!! Breadcrumbs::render($breadcrumb, @$item) !!}
@endsection --}}

@section('title', 'Пользователи')
@section('content_header')
<h1>Пользователи</h1>
@stop
@section('content')
<div id="toolbar">
    <a class="btn btn-primary" href="{{ route('admin.user.create') }}" role="button"><i class="fa fa-plus"></i> Новый пользователь
    </a>
</div>
<livewire:user-table/>
@endsection



{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}

@endpush

{{-- Push extra scripts --}}

@push('js')

@endpush
