@extends('admin')

{{-- @section('breadcrumbs')
{!! Breadcrumbs::render($breadcrumb, @$item) !!}
@endsection --}}


@section('title', 'Редактирование доступа')
@section('content_header')
<h1>Редактирование доступа</h1>
@stop



@section('content')

<form action="{{ route('admin.rap.permissions.update', $permission->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="form-group">

        <label for="permission">Наименование</label>
        <input type="text" class="form-control {!! @$permission->name ? ' is-valid ' : ' is-invalid ' !!}" name="name"
            id="name" required autofocus
            value="@if (old('name')) {{ old('name') }}@else{{ @$permission->name }} @endif">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

    </div>
    <div class="form-group">
        <label for="guard_name">Guard Name</label>
        <input type="text" name="guard_name" value="{{ @$permission->guard_name }}" class='form-control'
            placeholder='Guard Name'>
    </div>

    <div class=" py-3 form-row justify-content-center">
        <button type="submit" class="btn btn-primary float-right">Сохранить</button>
        <a class="btn btn-default " href="{{ route('admin.rap.permissions.index') }}" role="button">Отмена</a>
    </div>
</form>
@endsection
