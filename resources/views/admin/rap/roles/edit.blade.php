@extends('admin')
{{--
@section('breadcrumbs')
{!! Breadcrumbs::render($breadcrumb, @$role) !!}
@endsection --}}

@section('title', 'Редактирование роли')
@section('content_header')
<h1>Редактирование роли</h1>
@stop
@section('content')
<form action="{{ route('admin.rap.roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    {{-- <h5 class="card-title">Основная информация </h5> --}}
    <div class="form-group">
        <label for="name">Наименование</label>
        <input type="text" class="form-control {!! @$role->name ? ' is-valid ' : ' is-invalid ' !!}" name="name"
            id="name" required autofocus value="@if (old('name')) {{ old('name') }}@else{{ @$role->name }} @endif">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    </div>

    <div class="form-group">
        <label for="guard_name">Guard Name</label>
        <input type="text" name="guard_name" value="{{ $role->guard_name }}" class='form-control'
            placeholder='Guard Name'>
    </div>
    @include('admin.blocks.role_perms_form')

    <div class=" py-3 form-row justify-content-center">
        <button type="submit" class="btn btn-primary float-right">Сохранить</button>
        <a class="btn btn-default " href="{{ route('admin.rap.roles.index') }}" role="button">Отмена</a>
    </div>
</form>
@endsection
