@extends('user.layout')
@section('title', 'Dashboard User')
@push('styles')
<style>
.dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.dashboard-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.dashboard-card-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 1.8rem; flex-shrink: 0; }
.dashboard-card-info h3 { font-size: 1.1rem; color: #64748b; margin: 0 0 0.25rem 0; font-weight: 600; }
.dashboard-card-info p { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; }
</style>
@endpush

@section('content')
<div style="margin-bottom: 2rem;">
    <h2 style="font-size:1.5rem; margin-bottom: 0.25rem; font-weight: 400;">Halo,</h2>
    <h1 style="font-size:1.8rem; font-weight: 700; margin:0; text-transform: uppercase;">{{ $user->name }}</h1>
    <hr style="margin-top: 1rem; border:0; border-top:1px solid #e2e8f0;">
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="dashboard-card-icon" style="background: rgba(40, 91, 140, 0.1); color: #285b8c;">
            <i class="fa-solid fa-list-check"></i>
        </div>
        <div class="dashboard-card-info">
            <h3>Status Preferensi</h3>
            <p>{{ $preferensi ? 'Sudah Diisi' : 'Belum Diisi' }}</p>
        </div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-card-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
            <i class="fa-solid fa-star"></i>
        </div>
        <div class="dashboard-card-info">
            <h3>Total Ulasan Anda</h3>
            <p>{{ $ulasanCount }}</p>
        </div>
    </div>
</div>

<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; text-align: center; margin-top: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
    <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 3rem; color: #285b8c; margin-bottom: 1rem;"></i>
    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #0f172a;">Gunakan Sistem Cerdas</h3>
    <p style="color: #64748b; margin-bottom: 1.5rem; max-width: 500px; margin-left: auto; margin-right: auto;">
        Dapatkan rekomendasi kost yang paling sesuai dengan anggaran, lokasi, dan fasilitas yang Anda butuhkan.
    </p>
    <a href="{{ route('rekomendasi.index') }}" style="display: inline-block; background: #285b8c; color: #fff; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s;">
        Mulai Rekomendasi
    </a>
</div>
@endsection
