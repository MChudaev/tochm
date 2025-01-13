@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- @livewireStyles --}}
{{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.css') }}">
@vite('resources/css/app.css')

<link rel="stylesheet" href="{{ asset('vendor/bootstrap4-toggle/bootstrap4-toggle.min.css') }}">
{{-- просмотр фото --}}
<link href="{{ asset('vendor/venobox/venobox.min.css') }}" rel="stylesheet">
{{-- просмотр фото --}}
@stop

@section('js')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap4-toggle/bootstrap4-toggle.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script> --}}
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.js') }}"></script>
<x-livewire-alert::scripts />
{{-- просмотр фото --}}
<script src="{{ asset('/vendor/venobox/venobox.min.js') }}" type="text/javascript"></script>

<script>
    window.addEventListener('galleryModalPhoto', event => {
     new VenoBox({
        selector: '.my-image-links',
        numeration: true,
        infinigall: true,
        navigation	: true,
        titleattr: 'data-title',
        share: true,
  // overlayClose: true,
        spinner: 'plane',
        spinColor: '#00B1F0',
        maxWidth: '100%'
      //            share: true,
     //             spinner: 'rotating-plane'
            });
        })
</script>
<script>
    document.addEventListener("livewire:init", () => {
        Livewire.on("toast", (event) => {
           toastr[event.notify](event.message);
        });
    });
</script>

<script>
    // success message popup notification
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    // info message popup notification
    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    // warning message popup notification
    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif

    // error message popup notification
    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
</script>
@stop
