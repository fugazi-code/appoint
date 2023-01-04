@extends('layouts.external')

@section('content')
    <div class="app-auth-body mx-auto">
        <h2 class="text-center mb-4">
            <a class="app-logo" href="{{ route('home') }}">
                <img class="image-fuild" src="{{ asset('images/logo/mwa.jpg') }}" alt="logo" width="128" height="128">
            </a>
        </h2>
        <h2 class="text-center mb-4">Sign up to {{ env('APP_NAME') }}</h2>

        <div class="text-left mx-auto">
            <form method="POST" action="{{ route('register') }}" class="auth-form auth-signup-form">
                @csrf
                <div class="email mb-3">
                    <label class="sr-only" for="signup-email">{{ __('Your Name') }}</label>
                    <input id="name" type="text" class="form-control signup-name"
                        class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                        required autocomplete="name" autofocus placeholder="Type your full name...">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="email mb-3">
                    <label class="sr-only" for="signup-email">{{ __('Your Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" placeholder="Type your E-mail...">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="password mb-3">
                    <label class="sr-only" for="signup-password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="Create a password...">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="password mb-3">
                    <label class="sr-only" for="signup-password">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Type password to confirm...">
                </div>
                <div class="extra mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="agreed" name="tos">
                        <label class="form-check-label">
                            I agree to Portal's <a href="#" class="app-link">Terms of Service</a> and <a href="#"
                                class="app-link">Privacy
                                Policy</a>.
                        </label>
                    </div>
                    @error('tos')
                        <div class="alert alert-danger p-0 pl-2 fs-6" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!--//extra-->
                <div class="text-center">
                    <button type="submit" class="btn app-btn-primary btn-block theme-btn mx-auto shadow-sm">Sign Up
                    </button>
                </div>
            </form>
            <!--//auth-form-->

            <div class="auth-option text-center pt-5">Already have an account? <a class="text-link"
                    href="{{ route('login') }}">Log in</a>
            </div>
        </div>
        <!--//auth-form-container-->

    </div>
    <!--//auth-body-->
@endsection
