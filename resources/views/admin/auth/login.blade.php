@extends('layouts.app')

@section('content')
<div style="max-width:400px;margin:50px auto;padding:20px;border:1px solid #ccc;border-radius:8px;">
    <h2 style="text-align:center;margin-bottom:20px;">Admin Login</h2>

    @if($errors->any())
        <div style="color:red;margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('info'))
        <div style="color:orange;margin-bottom:10px;">
            {{ session('info') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div style="margin-bottom:10px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Password</label>
            <input type="password" name="password" required style="width:100%;padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>

        <button type="submit" style="width:100%;padding:10px;background:#007bff;color:white;border:none;border-radius:4px;">
            Login
        </button>
    </form>
</div>
@endsection
