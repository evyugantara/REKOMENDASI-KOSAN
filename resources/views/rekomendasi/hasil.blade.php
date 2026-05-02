@extends('user.layout')
@section('title', 'Hasil Rekomendasi Kost')
@push('styles')
<style>
.hasil-header { max-width:1280px; margin:0 auto; padding:3rem 1.5rem 2rem; }
.hasil-summary { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:2rem; }
.summary-card { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:16px; padding:1.25rem; text-align:center; }
.summary-card-val { font-size:1.6rem; font-weight:800; }
.summary-card-label { font-size:.75rem; color:#64748B; margin-top:.25rem; }
.pref-chip-wrap { display:flex; flex-wrap:wrap; gap:.5rem; margin-top:1rem; }
.pref-chip { background: var(--primary-light); border:1px solid var(--primary); color: var(--primary); padding:.3rem .75rem; border-radius: 20px; font-size:.75rem; font-weight:600; }
.hasil-grid { max-width:1280px; margin:0 auto; padding:0 1.5rem 4rem; display:flex; flex-direction:column; gap:1.5rem; }
.hasil-card { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:20px; display:grid; grid-template-columns:280px 1fr auto; overflow:hidden; transition:all .3s; }
.hasil-card:hover { border-color: var(--primary); box-shadow:0 15px 40px rgba(0,0,0,.15); transform:translateY(-2px); }
.hasil-card-img { position:relative; overflow:hidden; }
.hasil-card-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s; }
.hasil-card:hover .hasil-card-img img { transform:scale(1.06); }
.rank-badge { position:absolute; top:.75rem; left:.75rem; width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:800; z-index:2; }
.rank-1 { background:linear-gradient(135deg,#F59E0B,#D97706); box-shadow:0 4px 15px rgba(245,158,11,.4); }
.rank-2 { background:linear-gradient(135deg,#64748B,#64748B); }
.rank-3 { background:linear-gradient(135deg,#CD7F32,#B87333); }
.rank-other { background:rgba(255,255,255,.95); border:1px solid #E2E8F0; color:#64748B; }
.hasil-card-body { padding:1.5rem; }
.hasil-card-name { font-size:1.2rem; font-weight:700; margin-bottom:.4rem; }
.hasil-card-addr { font-size:.83rem; color:#64748B; display:flex; align-items:center; gap:.3rem; margin-bottom:1rem; }
.hasil-card-meta { display:flex; flex-wrap:wrap; gap:1rem; margin-bottom:1rem; }
.meta-item { display:flex; align-items:center; gap:.4rem; font-size:.85rem; }
.meta-item i { color: var(--primary); }
.score-breakdown { display:flex; flex-direction:column; gap:.5rem; }
.score-row { display:flex; align-items:center; gap:.75rem; }
.score-label { font-size:.75rem; color:#64748B; width:90px; flex-shrink:0; }
.score-track { flex:1; height:8px; background:#F8FAFC; border-radius:4px; overflow:hidden; }
.score-fill { height:100%; border-radius:4px; transition:width 1s ease; }
.score-val { font-size:.75rem; font-weight:700; width:35px; text-align:right; }
.hasil-card-side { padding:1.5rem; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:1rem; border-left:1px solid #E2E8F0; min-width:160px; }
.skor-circle { width:90px; height:90px; position:relative; }
.skor-circle svg { transform:rotate(-90deg); }
.skor-circle-text { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.skor-num { font-size:1.4rem; font-weight:800; }
.skor-label { font-size:.65rem; color:#64748B; }
.wa-btn { display:flex; align-items:center; gap:.5rem; background:linear-gradient(135deg,#25D366,#128C7E); color:#fff; padding:.6rem 1.1rem; border-radius:10px; text-decoration:none; font-size:.85rem; font-weight:700; transition:all .2s; white-space:nowrap; }
.wa-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(37,211,102,.3); }
.detail-btn { display:flex; align-items:center; gap:.5rem; background: var(--bg-white); border:1px solid var(--primary); color: var(--primary); padding:.6rem 1.1rem; border-radius:10px; text-decoration:none; font-size:.85rem; font-weight:600; transition:all .2s; white-space:nowrap; }
.detail-btn:hover { background: var(--primary-light); }
.empty-state { text-align:center; padding:4rem 1.5rem; }
.empty-icon { font-size:4rem; margin-bottom:1rem; }
@media(max-width:900px) { .hasil-card { grid-template-columns:1fr; } .hasil-card-img { height:200px; } .hasil-card-side { border-left:none; border-top:1px solid #E2E8F0; flex-direction:row; justify-content:space-around; } .hasil-summary { grid-template-columns:repeat(2,1fr); } }
</style>
@endpush

@section('content')
<div class="hasil-header">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:1.8rem;font-weight:800;">
                <i class="fa-solid fa-trophy" style="color:#F59E0B;"></i>
                Hasil Rekomendasi Kost
            </h1>
            <p style="color:#64748B;margin-top:.3rem;">Ditemukan <strong style="color:var(--primary);">{{ count($hasil) }}</strong> kost yang cocok dengan preferensi Anda</p>
        </div>
        <a href="{{ route('rekomendasi.index') }}" class="btn-secondary" style="padding:.6rem 1.2rem;font-size:.875rem;">
            <i class="fa-solid fa-sliders"></i> Ubah Preferensi
        </a>
    </div>

    <!-- Preferensi Summary -->
    <div class="hasil-summary">
        <div class="summary-card">
            <div class="summary-card-val" style="color: var(--primary);">Rp {{ number_format($preferensi->harga_min/1000,0) }}k - {{ number_format($preferensi->harga_max/1000,0) }}k</div>
            <div class="summary-card-label">Rentang Harga/bulan</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-val" style="color:#34D399;">≤ {{ $preferensi->jarak_max }} km</div>
            <div class="summary-card-label">Jarak dari Kampus</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-val" style="color:#FBBF24;">{{ $preferensi->tipe_kost ? ucfirst($preferensi->tipe_kost) : 'Semua' }}</div>
            <div class="summary-card-label">Tipe Kost</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-val" style="color:#F87171;">{{ count($hasil) }}</div>
            <div class="summary-card-label">Kost Ditemukan</div>
        </div>
    </div>
</div>

@if(count($hasil) > 0)
<div class="hasil-grid">
    @foreach($hasil as $i => $item)
    @php $kost = $item['kost']; $rank = $i + 1; @endphp
    <div class="hasil-card">
        <div class="hasil-card-img">
            <div class="rank-badge {{ $rank <= 3 ? 'rank-'.$rank : 'rank-other' }}">
                @if($rank == 1) 🥇 @elseif($rank == 2) 🥈 @elseif($rank == 3) 🥉 @else #{{ $rank }} @endif
            </div>
            <img src="{{ $kost->getFotoUtamaUrl() }}" alt="{{ $kost->nama }}" onerror="this.src='https://placehold.co/280x200/1E293B/818CF8?text=Kost'">
        </div>
        <div class="hasil-card-body">
            <div class="hasil-card-name">{{ $kost->nama }}</div>
            <div class="hasil-card-addr"><i class="fa-solid fa-location-dot fa-xs"></i> {{ $kost->alamat }}</div>
            <div class="hasil-card-meta">
                <div class="meta-item"><i class="fa-solid fa-dollar-sign fa-xs"></i> <strong>{{ $kost->getHargaFormatted() }}</strong>/bln</div>
                <div class="meta-item"><i class="fa-solid fa-route fa-xs"></i> {{ $kost->getJarakFormatted() }} dari UNSUR</div>
                <div class="meta-item"><i class="fa-solid fa-star fa-xs" style="color:#FCD34D;"></i> {{ number_format($kost->rating_rata,1) }}/5.0</div>
                <div class="meta-item"><i class="fa-solid fa-door-open fa-xs"></i> {{ $kost->kamar_tersedia }} kamar tersedia</div>
            </div>
            <div class="score-breakdown">
                <div class="score-row">
                    <div class="score-label">Harga (30%)</div>
                    <div class="score-track"><div class="score-fill" style="width:{{ $item['skor_harga'] }}%;background:var(--primary);"></div></div>
                    <div class="score-val" style="color:var(--primary);">{{ $item['skor_harga'] }}%</div>
                </div>
                <div class="score-row">
                    <div class="score-label">Fasilitas (35%)</div>
                    <div class="score-track"><div class="score-fill" style="width:{{ $item['skor_fasilitas'] }}%;background:linear-gradient(90deg,#10B981,#34D399);"></div></div>
                    <div class="score-val" style="color:#34D399;">{{ $item['skor_fasilitas'] }}%</div>
                </div>
                <div class="score-row">
                    <div class="score-label">Jarak (20%)</div>
                    <div class="score-track"><div class="score-fill" style="width:{{ $item['skor_jarak'] }}%;background:linear-gradient(90deg,#F59E0B,#FBBF24);"></div></div>
                    <div class="score-val" style="color:#FBBF24;">{{ $item['skor_jarak'] }}%</div>
                </div>
                <div class="score-row">
                    <div class="score-label">Rating (15%)</div>
                    <div class="score-track"><div class="score-fill" style="width:{{ $item['skor_rating'] }}%;background:linear-gradient(90deg,#EF4444,#F87171);"></div></div>
                    <div class="score-val" style="color:#F87171;">{{ $item['skor_rating'] }}%</div>
                </div>
            </div>
        </div>
        <div class="hasil-card-side">
            @php $pct = $item['skor']; $circ = 2 * pi() * 36; $dash = ($pct/100) * $circ; @endphp
            <div class="skor-circle">
                <svg width="90" height="90" viewBox="0 0 90 90">
                    <circle cx="45" cy="45" r="36" fill="none" stroke="#E2E8F0" stroke-width="7"/>
                    <circle cx="45" cy="45" r="36" fill="none"
                        stroke="{{ $pct >= 70 ? '#34D399' : ($pct >= 50 ? '#FBBF24' : '#F87171') }}"
                        stroke-width="7" stroke-linecap="round"
                        stroke-dasharray="{{ $dash }} {{ $circ }}"
                        style="transition:stroke-dasharray 1.5s ease;"/>
                </svg>
                <div class="skor-circle-text">
                    <div class="skor-num" style="color:{{ $pct >= 70 ? '#34D399' : ($pct >= 50 ? '#FBBF24' : '#F87171') }}">{{ $pct }}%</div>
                    <div class="skor-label">Cocok</div>
                </div>
            </div>
            <a href="https://wa.me/62{{ ltrim($kost->no_whatsapp, '0') }}?text=Halo,%20saya%20tertarik%20dengan%20kost%20{{ urlencode($kost->nama) }}" target="_blank" class="wa-btn">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            <a href="{{ route('kost.detail', $kost) }}" class="detail-btn">
                <i class="fa-solid fa-eye"></i> Detail
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon">🔍</div>
    <h2 style="font-size:1.3rem;margin-bottom:.75rem;">Tidak ada kost yang ditemukan</h2>
    <p style="color:#64748B;margin-bottom:1.5rem;">Coba perluas rentang harga atau jarak maksimal dari kampus.</p>
    <a href="{{ route('rekomendasi.index') }}" class="btn-primary">
        <i class="fa-solid fa-sliders"></i> Ubah Preferensi
    </a>
</div>
@endif
@endsection
