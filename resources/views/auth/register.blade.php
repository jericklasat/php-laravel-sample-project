<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        
<div class="columns">
    <div class="column column-left">
        <figure class="b-image-wrapper full-height image is-1by1">
            <img src="/images/logo3.jpeg" loading="lazy" class="has-ratio">
        </figure>
    </div>
    <div class="column column-right">
        <div class="section full-height">
            <div class="columns is-vcentered is-mobile is-centered">
                <div class="column is-half">
                    <div class="container">
                        <div class="">
                            <h2
                                class="is-size-3 has-text-white has-text-centered mb-5"
                            >
                                Create New Account
                            </h2>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="field has-text-white is-floating-in-label">
                                    <label class="label">Name</label>
                                    <div class="control has-icons-right is-clearfix">
                                        <input type="text" name="name" autocomplete="on" value="{{ old('name') }}" maxlength="50" required="required" class="input is-rounded is-small @error('name') is-danger @enderror">
                                        <span class="icon is-right has-text-primary"><i class="fa fa-user"></i></span>
                                    </div>
                                </div>
                                @error('name')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="field has-text-white is-floating-in-label">
                                    <label class="label">Email</label>
                                    <div class="control has-icons-right is-clearfix">
                                        <input type="email" name="email" autocomplete="on" value="{{ old('email') }}" maxlength="50" required="required" class="input is-rounded is-small @error('email') is-danger @enderror">
                                        <span class="icon is-right has-text-primary"><i class="fa fa-envelope"></i></span>
                                    </div>
                                </div>
                                @error('email')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="field has-text-white is-floating-in-label">
                                    <label class="label">Password</label>
                                    <div class="control has-icons-right is-clearfix">
                                        <input type="password" name="password" autocomplete="on" minlength="8" required="required" class="input is-rounded is-small @error('password') is-danger @enderror">
                                        <span class="icon is-right has-text-primary"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                <p class="help is-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="field has-text-white is-floating-in-label">
                                    <label class="label">Confirm Password</label>
                                    <div class="control has-icons-right is-clearfix">
                                        <input type="password" name="password_confirmation" autocomplete="on" minlength="8" required="required" class="input is-rounded is-small">
                                        <span class="icon is-right has-text-primary"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div>
                                <div class="field has-text-white is-floating-in-label">
                                    <a href="/login">Already have an account</a>
                                </div>
                                <div class="field mt-5">
                                    <div class="control">
                                        <button class="button is-fullwidth is-primary is-small is-rounded">Register Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
<script src="{{ asset('js/app.js') }}"></script>
<style>
    #app {
        height: 100vh;
        overflow: hidden;
    }
    .columns {
        padding: 0;
        margin: 0;
        height: 100%;
    }
    .column {
        padding: 0;
        margin: 0;
    }
    .full-height {
        height: 100%;
    }
    .column-right {
      background-color: #2c3741;
    }
    .button {
        border-radius: 0;
    }
</style>
{{-- <script src="{{ mix('js/register.js') }}"></script> --}}
</body>
</html>

