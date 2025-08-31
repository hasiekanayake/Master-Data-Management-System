@extends('layouts.app')

@section('title', 'Login - MDM System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-card p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-database-fill-gear display-4 text-brand"></i>
                    <h2 class="mt-2">Welcome Back</h2>
                    <p class="text-secondary">Sign in to access your MDM System</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                </form>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-brand">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
