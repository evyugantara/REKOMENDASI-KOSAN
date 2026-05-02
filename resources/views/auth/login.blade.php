@extends('layouts.app')
@section('title', 'Masuk')
@push('styles')
<style>
.auth-wrap { min-height: calc(100vh - 80px); display: flex; align-items: center; justify-content: center; padding: 2rem 1.5rem; background: radial-gradient(ellipse at 30% 50%, rgba(79,70,229,.15) 0%, transparent 60%), radial-gradient(ellipse at 70% 50%, rgba(16,185,129,.1) 0%, transparent 60%); }
.auth-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 440px; box-shadow: 0 30px 60px rgba(0,0,0,.4); }
.auth-logo { text-align: center; margin-bottom: 2rem; }
.auth-logo-icon { width: 60px; height: 60px; background: linear-gradient(135deg,#4F46E5,#10B981); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto .75rem; box-shadow: 0 8px 25px rgba(79,70,229,.35); }
.auth-title { font-size: 1.6rem; font-weight: 800; margin-bottom: .3rem; }
.auth-sub { color: #64748B; font-size: .9rem; }
.form-group { margin-bottom: 1.1rem; }
.form-label { display: block; font-size: .8rem; font-weight: 600; color: #64748B; margin-bottom: .4rem; }
.form-input { width: 100%; background: #F1F5F9; border: 1px solid #E2E8F0; border-radius: 10px; padding: .8rem 1rem; color: #0F172A; font-family: inherit; font-size: .9rem; transition: border-color .2s; }
.form-input:focus { outline: none; border-color: #4F46E5; box-shadow: 0 0 0 3px rgba(79,70,229,.1); }
.form-input.error { border-color: #EF4444; }
.form-error { color: #FCA5A5; font-size: .775rem; margin-top: .3rem; }
.input-wrap { position: relative; }
.input-wrap .toggle-pw { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748B; cursor: pointer; }
.btn-block { width: 100%; padding: .9rem; font-size: 1rem; border-radius: 12px; }
.auth-divider { text-align: center; color: #475569; font-size: .8rem; margin: 1.25rem 0; display: flex; align-items: center; gap: .75rem; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: #E2E8F0; }
.auth-link { color: #818CF8; text-decoration: none; font-weight: 600; }
.auth-link:hover { text-decoration: underline; }
.remember-wrap { display: flex; align-items: center; gap: .5rem; }
.remember-wrap input { accent-color: #4F46E5; }
.remember-wrap label { font-size: .85rem; color: #64748B; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🏠</div>
            <div class="auth-title">Selamat Datang!</div>
            <div class="auth-sub">Masuk ke akun KostUnsur Anda</div>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;">
            @foreach($errors->all() as $e)
                <div style="color:#FCA5A5;font-size:.825rem;"><i class="fa-solid fa-circle-xmark fa-xs"></i> {{ $e }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}" placeholder="mahasiswa@unsur.ac.id" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" name="password" id="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="••••••••" required>
                    <button type="button" class="toggle-pw" onclick="togglePw()"><i class="fa-solid fa-eye" id="pwEyeIcon"></i></button>
                </div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
                <div class="remember-wrap">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>
            </div>
            <button type="submit" class="btn-primary btn-block">
                <i class="fa-solid fa-right-to-bracket fa-sm"></i> Masuk
            </button>
        </form>

        <div class="auth-divider">atau</div>
        <div style="text-align:center;font-size:.875rem;color:#64748B;">
            Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function togglePw() {
    const pw = document.getElementById('password');
    const ic = document.getElementById('pwEyeIcon');
    if (pw.type === 'password') { pw.type = 'text'; ic.className = 'fa-solid fa-eye-slash'; }
    else { pw.type = 'password'; ic.className = 'fa-solid fa-eye'; }
}
</script>
@endpush
