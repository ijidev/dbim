@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: white; padding: 2.5rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); width: 100%; max-width: 400px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.875rem; font-weight: 700; color: #1e293b; letter-spacing: -0.025em;">Create Account</h2>
            <p style="color: #64748b; margin-top: 0.5rem;">Join the DBIM community today</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#cbd5e1'">
                @error('name')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#cbd5e1'">
                @error('email')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Password</label>
                <input id="password" type="password" name="password" required
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#cbd5e1'">
                @error('password')
                    <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password-confirm" style="display: block; font-size: 0.875rem; font-weight: 500; color: #475569; margin-bottom: 0.5rem;">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#cbd5e1'">
            </div>

            <button type="submit" 
                style="width: 100%; background-color: var(--primary-color); color: white; padding: 0.875rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; transition: opacity 0.2s;"
                onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                Create Account
            </button>
        </form>

        <div style="margin: 2rem 0; display: flex; align-items: center;">
            <div style="flex-grow: 1; height: 1px; background-color: #e2e8f0;"></div>
            <span style="padding: 0 1rem; color: #94a3b8; font-size: 0.875rem;">Or continue with</span>
            <div style="flex-grow: 1; height: 1px; background-color: #e2e8f0;"></div>
        </div>

        <a href="{{ route('auth.google') }}" 
           style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; background: white; color: #475569; font-weight: 500; cursor: pointer; transition: background-color 0.2s; text-decoration: none;">
            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.75rem;" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.2 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Sign up with Google
        </a>

        <p style="text-align: center; margin-top: 2rem; color: #64748b; font-size: 0.875rem;">
            Already have an account? 
            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 500;">Sign in</a>
        </p>
    </div>
</div>
@endsection
