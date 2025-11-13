@extends('layouts.app')

@section('content')
<h1>Dashboard Admin</h1>

@if(session('info'))
    <div style="color:orange">{{ session('info') }}</div>
@endif

@if(session('show2faPrompt'))
    <div style="border:1px solid #ccc;padding:10px;margin:10px 0;">
        <p>Two-Factor Authentication belum aktif.</p>
        <form method="POST" action="{{ route('admin.enable2fa') }}">
            @csrf
            <button type="submit">Aktifkan 2FA & Generate Recovery Codes</button>
        </form>
    </div>
@endif

@if(session('success'))
    <div style="color:green">{{ session('success') }}</div>
    <p>Recovery Codes (simpan aman, tiap kode bisa dipakai sekali):</p>
    <ul>
        @foreach(json_decode(decrypt(Auth::user()->two_factor_recovery_codes),true) as $code)
            <li>{{ $code }}</li>
        @endforeach
    </ul>
@endif
@endsection
