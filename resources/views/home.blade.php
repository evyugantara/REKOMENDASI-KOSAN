@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
/* Hero Section - Kosania Style */
.hero-kosania {
    position: relative;
    height: 480px;
    background-image: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=2070&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    padding: 0 5%;
}

.hero-kosania::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    /* Gradient overlay matching the requested theme color #285b8c */
    background: linear-gradient(90deg, rgba(40, 91, 140, 0.95) 0%, rgba(40, 91, 140, 0.5) 50%, rgba(255, 255, 255, 0) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    color: #fff;
    max-width: 600px;
}

.hero-content h1 {
    font-size: 2.8rem;
    font-weight: 300;
    line-height: 1.3;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.hero-content h1 span {
    font-weight: 800;
}

/* Floating Search Box */
.search-box-wrapper {
    max-width: 950px;
    margin: -60px auto 4rem auto;
    position: relative;
    z-index: 10;
    padding: 0 1rem;
}

.kosania-search-box {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    padding: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 1rem;
}

.search-field {
    flex: 1;
    min-width: 200px;
}

.search-field label {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: 0.5rem;
}

.search-input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input-group i {
    position: absolute;
    left: 1rem;
    color: #94a3b8;
}

.search-input-group input, .search-input-group select {
    width: 100%;
    padding: 0.8rem 1rem 0.8rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #0f172a;
    transition: all 0.2s;
    background: #f8fafc;
}

.search-input-group select {
    padding-left: 1rem;
}

.search-input-group input:focus, .search-input-group select:focus {
    outline: none;
    border-color: var(--primary);
    background: #ffffff;
}

.btn-cari-kosania {
    background-color: var(--primary); /* Dark Blue */
    color: #fff;
    font-weight: 700;
    padding: 0.8rem 2.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
    height: 46px;
}

.btn-cari-kosania:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

/* Kosania Style Cards Section */
.rekomendasi-section {
    max-width: 1200px;
    margin: 0 auto 5rem;
    padding: 0 1rem;
}

.rekomendasi-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 400;
    color: #475569;
    margin-bottom: 2.5rem;
}

.kosania-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.kosania-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: transform 0.3s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}

.kosania-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.1);
}

.kc-img-wrapper {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.kc-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.kosania-card:hover .kc-img-wrapper img {
    transform: scale(1.05);
}

.kc-badge {
    position: absolute;
    top: 0;
    right: 0;
    background-color: var(--primary); /* Default Dark Blue */
    color: #fff;
    padding: 0.4rem 1.25rem;
    font-size: 0.85rem;
    font-weight: 600;
    border-bottom-left-radius: 12px;
    z-index: 2;
}

.kc-badge.putra { background-color: var(--primary); } /* Dark Blue */
.kc-badge.putri { background-color: var(--black); } /* Black */
.kc-badge.campur { background-color: #475569; } /* Dark Gray */

.kc-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.kc-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.kc-location {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 1.5rem;
}

.kc-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.kc-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary); /* Dark Blue */
}

.kc-btn {
    background-color: var(--primary); /* Dark Blue */
    color: #fff;
    padding: 0.5rem 1.25rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: background 0.2s;
}

.kosania-card:hover .kc-btn {
    background-color: var(--primary-hover);
}

@media (max-width: 1024px) {
    .kosania-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .kosania-search-box { flex-direction: column; align-items: stretch; }
    .btn-cari-kosania { width: 100%; }
    .hero-content h1 { font-size: 2rem; }
    .hero-kosania { height: 400px; }
    .kosania-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="hero-kosania">
    <div class="hero-content">
        <h1>Lagi nyari kos kosan? <span>KostUNSUR</span> aja</h1>
    </div>
</section>

<!-- FLOATING SEARCH BOX -->
<div class="search-box-wrapper">
    <form action="{{ route('kost.index') }}" method="GET" class="kosania-search-box">
        
        <div class="search-field" style="flex: 2;">
            <label>Dimana Anda berencana tinggal?</label>
            <div class="search-input-group">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" name="search" placeholder="Dimana Anda berencana tinggal?">
            </div>
        </div>

        <div class="search-field">
            <label>Tipe Kost</label>
            <div class="search-input-group">
                <select name="tipe" style="padding-left:1rem;">
                    <option value="">Semua Tipe</option>
                    <option value="putra">Putra</option>
                    <option value="putri">Putri</option>
                    <option value="campur">Campur</option>
                </select>
            </div>
        </div>

        <div class="search-field">
            <label>Harga Maks</label>
            <div class="search-input-group">
                <select name="harga_max" style="padding-left:1rem;">
                    <option value="">Semua Harga</option>
                    <option value="500000">Rp 500.000</option>
                    <option value="1000000">Rp 1.000.000</option>
                    <option value="2000000">Rp 2.000.000</option>
                </select>
            </div>
        </div>

        <div style="flex-shrink: 0;">
            <button type="submit" class="btn-cari-kosania">CARI</button>
        </div>

    </form>
</div>

<!-- CTA SISTEM CERDAS -->
<section style="max-width: 1200px; margin: 0 auto 4rem; padding: 0 1rem;">
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-hover)); border-radius: 16px; padding: 3rem 2rem; text-align: center; color: #fff; box-shadow: 0 10px 30px rgba(40,91,140,0.2); position: relative; overflow: hidden;">
        <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 5rem; opacity: 0.1; position: absolute; right: 5%; top: 50%; transform: translateY(-50%);"></i>
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.75rem; position: relative; z-index: 2;">Bingung Pilih Kost yang Pas?</h2>
        <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; position: relative; z-index: 2;">Jangan buang waktu mencari satu-satu. Gunakan <b>Sistem Rekomendasi Cerdas</b> kami yang akan mencarikan kost terbaik berdasarkan budget, lokasi, dan fasilitas yang Anda butuhkan.</p>
        <a href="{{ route('rekomendasi.index') }}" style="display: inline-block; background: #fff; color: var(--primary); padding: 1rem 2.5rem; border-radius: 50px; font-weight: 800; font-size: 1.1rem; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; position: relative; z-index: 2; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <i class="fa-solid fa-bolt" style="color: #f59e0b; margin-right: 0.5rem;"></i> Coba Sistem Cerdas Sekarang
        </a>
    </div>
</section>

<!-- KAMAR KOSAN SECTION -->
<section class="rekomendasi-section">
    <h2 class="rekomendasi-title">Daftar Kamar Kosan</h2>
    
    <div class="kosania-grid">
        @foreach($kostTerbaru as $kost)
        <a href="{{ route('kost.detail', $kost->id) }}" class="kosania-card">
            <div class="kc-img-wrapper">
                <img src="{{ $kost->getFotoUtamaUrl() }}" alt="{{ $kost->nama }}" onerror="this.src='https://placehold.co/400x300/1E293B/818CF8?text=KostUnsur'">
                <div class="kc-badge {{ $kost->tipe }}">{{ ucfirst($kost->tipe) }}</div>
            </div>
            <div class="kc-body">
                <div class="kc-title">{{ $kost->nama }}</div>
                <div class="kc-location">{{ $kost->kecamatan ?? 'Cianjur' }}, Jawa Barat</div>
                
                <div class="kc-footer">
                    <div class="kc-price">Rp {{ number_format($kost->harga_per_bulan, 0, ',', '.') }}/bulan</div>
                    <div class="kc-btn">Cek Sekarang</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('kost.index') }}" style="color: var(--primary); font-weight: 600; text-decoration: none; border: 2px solid var(--primary); padding: 0.75rem 2rem; border-radius: 50px; transition: all 0.2s; display: inline-block;">
            Lihat Semua Kost
        </a>
    </div>
</section>

@endsection
