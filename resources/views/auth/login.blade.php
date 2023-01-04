@extends('layouts.external')

@section('content')

    <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2">{{ env('APP_NAME') }}</h1>
                    <p class="lead">
                        Sign in to your account to continue
                    </p>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-4">
                            <div class="text-center">
                                <img src="{{ asset('images/logo/mwa.jpg') }}" alt="Charles Hall" class="img-fluid"
                                    width="125" height="125" />
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Type your E-mail..." autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"
                                        placeholder="Type your Password..." required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link btn-sm" style="font-size: 0.7rem"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                <div class="text-center mt-3">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            Sign In
                                        </button>
                                    </div>
                                </div>
                            </form>

{{--                            <div class="text-center pt-3">No Account? Sign up--}}
{{--                                <a href="{{ route('register') }}">here</a>.--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
