@extends('layouts.external')

@section('content')
    <div class="mx-auto">
        <div class="text-center mb-4">
            <a class="app-logo" href="{{ route('home') }}">
                <img class="mr-2" src="{{ asset('images/logo/mwa.jpg') }}" alt="logo" width="128" height="128">
            </a>
        </div>
        <h2 class="text-center mb-4">{{ __('Reset Password') }}</h2>

        <div class="mb-4 text-center">Enter your email address below. We'll email you a link to a page where
            you can easily create a new password.
        </div>

        <div class="auth-form-container text-left">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="auth-form resetpass-form">
                @csrf
                <div class="email mb-3">
                    <label for="email"
                           class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label><input
                        id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div><!--//form-group-->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block shadow mx-auto">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>

            <div class="auth-option text-center pt-5">
                <a class="app-link" href="{{ route('login') }}">Log in</a>
                <span class="px-2">|</span>
                <a class="app-link" href="{{ route('register') }}">Sign up</a>
            </div>
        </div><!--//auth-form-container-->
    </div><!--//auth-body-->
@endsection
