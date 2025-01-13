@extends('admin')
@section('title', 'Пользователи')
@section('content_header')
<h1>Редактирование пользователя</h1>
@stop
@section('content')
<div class="row">
    <!-- left column -->
    <div class=" col-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Редактирование пользователя</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" value="{{ $user->last_name }}"
                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                            name="last_name" placeholder="Иванов" />
                        @error('last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" value="{{ $user->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Иван" />
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="patronymic">Отчество</label>
                        <input type="text" value="{{ $user->patronymic }}"
                            class="form-control @error('patronymic') is-invalid @enderror" id="patronymic"
                            name="patronymic" placeholder="Иванович" />
                        @error('patronymic')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" value="{{ $user->email }}"
                            class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            placeholder="Enter email" />
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Телефон</label>
                        <input type="text" value="{{ $user->phone_number }}"
                            data-inputmask='"mask": "+9 (999) 999-9999"' data-mask
                            class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                            name="phone_number" />
                        @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                    </div>
                    {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" />
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div> --}}
                </div>
                <!-- /.card-body -->

                @include('admin.blocks.user_roles_form')
                @include('admin.blocks.user_perms_form')

                <div class="card-footer">
                    <div class=" py-3 form-row justify-content-center">

                        <button type="submit" class="btn btn-primary float-right">Обновить</button>
                        <a class="btn btn-default " href="{{ route('admin.user.index') }}" role="button">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->
@endsection


{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}

@endpush

{{-- Push extra scripts --}}

@push('js')
<script src="{{ asset('js/jquery.inputmask.min.js') }}" type="text/javascript"></script>

<script>
    $(function() {
        $('[data-mask]').inputmask()
    })
</script>
@endpush
