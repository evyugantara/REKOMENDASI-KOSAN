@extends('layouts.app')
@section('title', 'Daftar Akun')
@push('styles')
<style>
.auth-wrap { min-height:calc(100vh - 80px); display:flex; align-items:center; justify-content:center; padding:2rem 1.5rem; background:radial-gradient(ellipse at 30% 50%, rgba(79,70,229,.15) 0%, transparent 60%), radial-gradient(ellipse at 70% 50%, rgba(16,185,129,.1) 0%, transparent 60%); }
.auth-card { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:24px; padding:2.5rem; width:100%; max-width:500px; box-shadow:0 30px 60px rgba(0,0,0,.4); }
.auth-logo { text-align:center; margin-bottom:1.75rem; }
.auth-logo-icon { width:56px; height:56px; background:linear-gradient(135deg,#4F46E5,#10B981); border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; margin:0 auto .6rem; box-shadow:0 8px 25px rgba(79,70,229,.35); }
.form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.form-group { margin-bottom:1rem; }
.form-label { display:block; font-size:.8rem; font-weight:600; color:#64748B; margin-bottom:.4rem; }
.form-input { width:100%; background:#F1F5F9; border:1px solid #E2E8F0; border-radius:10px; padding:.75rem 1rem; color:#0F172A; font-family:inherit; font-size:.875rem; transition:border-color .2s; }
.form-input:focus { outline:none; border-color:#4F46E5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
.form-input.error { border-color:#EF4444; }
.form-error { color:#FCA5A5; font-size:.775rem; margin-top:.3rem; }
.btn-block { width:100%; padding:.85rem; font-size:1rem; border-radius:12px; }
.auth-link { color:#818CF8; text-decoration:none; font-weight:600; }
.auth-link:hover { text-decoration:underline; }
.input-wrap { position:relative; }
.toggle-pw { position:absolute; right:.85rem; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748B; cursor:pointer; }
@media(max-width:480px) { .form-grid-2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🎓</div>
            <div style="font-size:1.5rem;font-weight:800;margin-bottom:.2rem;">Buat Akun Baru</div>
            <div style="color:#64748B;font-size:.875rem;">Mulai temukan kost terbaik Anda</div>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:.75rem 1rem;margin-bottom:1rem;">
            @foreach($errors->all() as $e)
                <div style="color:#FCA5A5;font-size:.825rem;"><i class="fa-solid fa-circle-xmark fa-xs"></i> {{ $e }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap *</label>
                    <input type="text" name="name" id="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}" placeholder="Nama Anda" value="{{ old('name') }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="npm">NPM</label>
                    <input type="text" name="npm" id="npm" class="form-input" placeholder="5520122034" value="{{ old('npm') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email *</label>
                <input type="email" name="email" id="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}" placeholder="email@unsur.ac.id" value="{{ old('email') }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label" for="phone">No. WhatsApp</label>
                    <input type="text" name="phone" id="phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="prodi">Program Studi</label>
                    <input type="text" name="prodi" id="prodi" class="form-input" placeholder="Teknik Informatika" value="{{ old('prodi', 'Teknik Informatika') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password *</label>
                <div class="input-wrap">
                    <input type="password" name="password" id="password" class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="Minimal 6 karakter" required>
                    <button type="button" class="toggle-pw" onclick="togglePw()"><i class="fa-solid fa-eye" id="pwEye"></i></button>
                </div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn-primary btn-block" style="margin-top:.5rem;">
                <i class="fa-solid fa-user-plus fa-sm"></i> Daftar Sekarang
            </button>
        </form>

        <div style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:#64748B;">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk</a>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function togglePw() {
    const pw = document.getElementById('password');
    const ic = document.getElementById('pwEye');
    if (pw.type === 'password') { pw.type = 'text'; ic.className = 'fa-solid fa-eye-slash'; }
    else { pw.type = 'password'; ic.className = 'fa-solid fa-eye'; }
}
</script>
@endpush
