@extends('user.layout')
@section('title', 'Dashboard User')
@push('styles')
<style>
.dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
/* CoreUI Cards */
.c-card { border-radius: 6px; color: #fff; position: relative; overflow: hidden; display: flex; flex-direction: column; min-height: 140px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
.c-card-body { padding: 1.25rem; z-index: 2; position: relative; flex: 1; }
.c-card .dropdown { position: absolute; right: 1.25rem; top: 1.25rem; opacity: 0.8; cursor: pointer; }
.c-value { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.1rem; display: flex; align-items: center; gap: 0.5rem; }
.c-value span { font-size: 0.8rem; font-weight: 400; opacity: 0.8; }
.c-label { font-size: 0.95rem; opacity: 0.9; }
.c-card-primary { background-color: var(--primary); }
.c-card-info { background-color: var(--info); }
.c-chart { position: absolute; bottom: 0; left: 0; width: 100%; height: 60px; opacity: 0.4; }
</style>
@endpush

@section('content')
<div style="margin-bottom: 2rem;">
    <h2 style="font-size:1.5rem; margin-bottom: 0.25rem; font-weight: 400;">Halo,</h2>
    <h1 style="font-size:1.8rem; font-weight: 700; margin:0; text-transform: uppercase;">{{ $user->name }}</h1>
    <hr style="margin-top: 1rem; border:0; border-top:1px solid #e2e8f0;">
</div>

<div class="dashboard-grid">
    <div class="c-card c-card-primary">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $preferensi ? 'Sudah Diisi' : 'Belum Diisi' }} <span>(Preferences)</span></div>
            <div class="c-label">Status Preferensi Kost Anda</div>
        </div>
        <div class="c-chart">
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:100%;"><polyline fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" points="0,20 20,15 40,25 60,10 80,18 100,5"></polyline></svg>
        </div>
    </div>
    <div class="c-card c-card-info">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $ulasanCount }} <span>(Reviews)</span></div>
            <div class="c-label">Total Ulasan Anda</div>
        </div>
        <div class="c-chart">
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:100%;"><polyline fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" points="0,25 20,20 40,28 60,15 80,5 100,10"></polyline></svg>
        </div>
    </div>
</div>

<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; text-align: center; margin-top: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
    <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--text-main);">Gunakan Sistem Cerdas</h3>
    <p style="color: var(--text-muted); margin-bottom: 1.5rem; max-width: 500px; margin-left: auto; margin-right: auto;">
        Dapatkan rekomendasi kost yang paling sesuai dengan anggaran, lokasi, dan fasilitas yang Anda butuhkan.
    </p>
    <a href="{{ route('rekomendasi.index') }}" style="display: inline-block; background: var(--primary); color: #fff; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s;">
        Mulai Rekomendasi
    </a>
</div>
@endsection
