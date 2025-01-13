@extends('admin')

{{-- @section('breadcrumbs')
    {!! Breadcrumbs::render($breadcrumb, @$item) !!}
@endsection --}}


@section('title', 'Роли и доступы пользователей')
@section('content_header')
<h1>Роли и доступы пользователей</h1>
@stop
@section('content')
    <div class="card-columns">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Роли пользователей </h5>
                <p class="card-text"></p>
                <a class="btn btn-primary" href="{{ route('admin.rap.roles.index') }}" role="button">Перейти</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Доступы пользователей</h5>
                <p class="card-text"></p>
                <a class="btn btn-primary" href="{{ route('admin.rap.permissions.index') }}" role="button">Перейти</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
@endsection
