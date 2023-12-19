<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/logo/ACST-logo.png') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Agne Construction Supplies") }}</title>

        <!-- Jquery -->
        <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- CSS -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

        <!-- Toastr -->
        <link href="{{ asset('toastr/css/toastr.css') }}" rel="stylesheet" />
        <script
            type="text/javascript"
            src="{{ asset('toastr/js/toastr.min.js') }}"
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        <script
            type="text/javascript"
            src="{{ asset('toastr/js/toastr_option.js') }}"
        ></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=Nunito"
            rel="stylesheet"
        />

        <!-- Fontawesome Css -->
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/solid.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/brands.min.css') }}" rel="stylesheet" />

        <script
            type="text/javascript"
            src="{{ asset('sweetalert/sweetalert.min.js') }}"
        ></script>

        <!-- Datatable -->
        <link href="{{ asset('datatable/datatable.min.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="{{ asset('datatable/datatable.min.js') }}"></script>
        <script>
            $(document).ready( function () {
                $('.display').DataTable();
            } );
        </script>

        <!-- Tooltip -->
        <script type="module" src="">
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>

        <!-- CKeditor -->
        <script src="{{ asset('js/ckeditor.js') }}"></script>

    </head>
    <body>
        <div id="app">
            <div class="container-fluid" style="height: 70px; background-color: #31304D;">

            </div>
            @if(Auth::id()) 
            
                @if(Auth::user()->user_type != 'admin')
                    @include('partials.navigation') 
                @endif 
                
                @if(Auth::user()->user_type == 'admin') 
                    @include('partials.admin_navigation') 
                @endif 
            @else
                @include('partials.navigation') 
            @endif

            <main class="min-vh-100 mb-4">
                @yield('content')
            </main>
            @include('partials.footer')
    </div>
    @include('sweetalert::alert')
    @yield('ckeditor')
    @yield('chart')
    </body>
</html>
