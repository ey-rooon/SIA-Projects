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
    </head>
    <body>
        <!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Login") }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-end"
                                >{{ __("Email Address") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                />

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-end"
                                >{{ __("Password") }}</label
                            >

                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                />

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                    type="checkbox" name="remember"
                                    id="remember"
                                    {{ old("remember") ? "checked" : "" }}>

                                    <label
                                        class="form-check-label"
                                        for="remember"
                                    >
                                        {{ __("Remember Me") }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Login") }}
                                </button>

                                @if (Route::has('password.request'))
                                <a
                                    class="btn btn-link"
                                    href="{{ route('password.request') }}"
                                >
                                    {{ __("Forgot Your Password?") }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

            <section
            class="vh-100"
            style='
                background-image: url("{{ asset("storage/images/login-bg.jpg") }}"); 
                background-repeat: no-repeat;
                background-size: cover;'
            >
            <!-- Your content goes here -->


            <div class="container py-5 h-100">
                <div
                    class="row d-flex justify-content-center align-items-center h-100"
                >
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div
                            class="card shadow-2-strong"
                            style="border-radius: 1rem"
                        >
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="card-body p-5 text-center">
                                    <a href="/"
                                        ><img
                                            src="{{
                                                asset(
                                                    'storage/logo/ACST-logo.png'
                                                )
                                            }}"
                                            class=" mb-5"
                                            height="300px"
                                            alt=""
                                    /></a>

                                    <!-- Email input -->
                                    <div class="form-floating mb-4">
                                        <input
                                            id="email"
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="email"
                                            placeholder="Email Address"
                                            autofocus
                                        />
                                        <label for="email">{{
                                            __("Email Address")
                                        }}</label>
                                        @error('email')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-floating mb-4">
                                        <input
                                            id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Password"
                                        />
                                        <label for="password">{{
                                            __("Password")
                                        }}</label>

                                        @error('password')
                                        <span
                                            class="invalid-feedback"
                                            role="alert"
                                        >
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <!-- Checkbox -->
                                    <div
                                        class="form-check d-flex justify-content-center mb-4"
                                    >
                                        <input class="form-check-input me-2"
                                        type="checkbox" name="remember"
                                        id="remember"
                                        {{ old("remember") ? "checked" : "" }}>

                                        <label
                                            class="form-check-label"
                                            for="remember"
                                        >
                                            {{ __("Remember Me") }}
                                        </label>
                                    </div>

                                    <!-- Submit button -->
                                    <div class="row px-3">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-block mb-4"
                                        >
                                            {{ __("Login") }}
                                        </button>
                                    </div>
                                    <div class="row">
                                        @if (Route::has('password.request'))
                                        <a
                                            class="btn btn-link"
                                            href="{{
                                                route('password.request')
                                            }}"
                                        >
                                            {{ __("Forgot Your Password?") }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
