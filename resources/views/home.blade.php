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
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1), inset 0 0 0 1px rgba(255,255,255,0.2);
    padding: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 1rem;
    transition: transform 0.3s ease;
}
.kosania-search-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12), inset 0 0 0 1px rgba(255,255,255,0.3);
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

/* Pagination */
.pagination { display:flex; gap:.4rem; justify-content:center; flex-wrap:wrap; margin-top:3rem; }
.pagination a, .pagination span { padding:.5rem .85rem; border-radius:8px; font-size:.875rem; font-weight:500; text-decoration:none; }
.pagination a { background:#FFFFFF; border:1px solid #E2E8F0; color:#475569; transition:all .2s; }
.pagination a:hover { border-color:var(--primary); color:var(--primary); }
.pagination span.active-page { background:var(--primary); color:#fff; border:1px solid var(--primary); }
.pagination span.disabled { background:#FFFFFF; border:1px solid #E2E8F0; color:#E2E8F0; }

/* Animations */
@keyframes movingGradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animated-gradient-bg {
    background: linear-gradient(-45deg, var(--primary), var(--info), var(--primary-hover), #4F46E5);
    background-size: 400% 400%;
    animation: movingGradient 10s ease infinite;
}
@keyframes pulseGlow {
    0% { box-shadow: 0 0 0 0 rgba(255,255,255, 0.7); }
    70% { box-shadow: 0 0 0 15px rgba(255,255,255, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255,255,255, 0); }
}
.btn-pulse {
    animation: pulseGlow 2s infinite;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.hero-content h1 {
    animation: fadeInUp 1s ease-out forwards;
}
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="hero-kosania">
    <div class="hero-content">
        <h1 style="font-size: 3.5rem;">Selamat Datang,<br><span>Mahasiswa UNSUR</span></h1>
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
    
    @if($kostTerbaru->hasPages())
    <div class="pagination">
        @if($kostTerbaru->onFirstPage())
            <span class="disabled">← Prev</span>
        @else
            <a href="{{ $kostTerbaru->previousPageUrl() }}">← Prev</a>
        @endif
        @foreach($kostTerbaru->getUrlRange(1, $kostTerbaru->lastPage()) as $page => $url)
            @if($page == $kostTerbaru->currentPage())
                <span class="active-page">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach
        @if($kostTerbaru->hasMorePages())
            <a href="{{ $kostTerbaru->nextPageUrl() }}">Next →</a>
        @else
            <span class="disabled">Next →</span>
        @endif
    </div>
    @endif
</section>

@endsection
