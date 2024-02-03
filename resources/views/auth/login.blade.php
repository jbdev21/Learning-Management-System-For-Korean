@extends('layouts.empty')

@section('content')
<div class="login-content">
    <div class="panel panel-default login-box">
        <div class="panel-body p-5">
            <div class="title">
                <img class="center-block" src="/images/logo.png" alt="">
                <h3 class="text-center">GW English</h3>
            </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p>
                        <input id="email" placeholder=" username" type="text" class="form-control input-lg @error('email') is-invalid @enderror" name="username" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </p>

                    <p>
                        <input id="password" placeholder=" password" type="password" class="form-control  input-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </p>
                    <p>
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </p>
         
                         
                    <button type="submit" class="btn btn-primary btn-lg">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                   
            </form>
        </div>
    </div>

</div>
@endsection
