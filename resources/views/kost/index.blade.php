@extends('layouts.app')
@section('title', 'Daftar Kost')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
<style>
.cari-layout { max-width:1280px; margin:0 auto; padding:2rem 1.5rem 4rem; display:grid; grid-template-columns:280px 1fr; gap:2rem; }
.filter-sidebar { position:sticky; top:90px; align-self:start; }
.filter-card { background:#FFFFFF; border:1px solid var(--border-color); border-radius: 12px; margin-bottom: 1.5rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
.filter-title { background: #fff; color: var(--text-main); padding: 1.25rem 1.25rem 0.5rem; font-weight: 700; display:flex; align-items:center; gap:.5rem; font-size:1.05rem; }
.filter-title i { color: var(--primary); }
.filter-body { padding: 0.5rem 1.25rem 1.25rem; }
.filter-section { margin-bottom:1.5rem; }
.filter-section:last-child { margin-bottom:0; }
.filter-label { font-size:.85rem; font-weight:600; color:#333; margin-bottom:.5rem; display:block; }
.filter-input { width:100%; background:#f8fafc; border:2px solid #e2e8f0; border-radius: 8px; padding:.6rem .8rem; color:#333; font-size:.875rem; font-family:inherit; transition: all 0.2s; }
.filter-input:focus { outline:none; border-color:var(--primary); background: #fff; }
.filter-radio-group, .filter-check-group { display:flex; flex-direction:column; gap:.6rem; }
.filter-radio, .filter-check { display:flex; align-items:center; gap:.6rem; cursor:pointer; font-size:.9rem; color:var(--text-main); transition: color 0.2s; }
.filter-radio:hover, .filter-check:hover { color: var(--primary); }
.filter-btn { width:100%; padding:.85rem; border-radius:8px; margin-top:1rem; background: var(--primary); color: #fff; border: none; cursor: pointer; font-weight: 700; transition: all 0.2s; }
.filter-btn:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(50,31,219,0.2); }
.reset-btn { width:100%; padding:.65rem; border-radius:4px; margin-top:.5rem; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; font-size:.875rem; font-weight:600; cursor:pointer; text-align: center; display: block; text-decoration: none; }
.kost-main {}

/* Slider Styles */
.noUi-target { background: #E2E8F0; border: none; box-shadow: inset 0 1px 3px rgba(0,0,0,.1); height: 6px; }
.noUi-connect { background: var(--primary); }
.noUi-handle { border: 2px solid var(--primary); background: #FFFFFF; box-shadow: 0 0 4px rgba(0,0,0,.2); border-radius: 50%; width: 20px !important; height: 20px !important; right: -10px !important; top: -7px !important; cursor: pointer; }
.noUi-handle::before, .noUi-handle::after { display: none; }
.noUi-tooltip { display: none; }
.kost-topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; flex-wrap:wrap; gap:.75rem; }
.kost-count { font-size:.9rem; color:#64748B; }
.sort-select { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:10px; padding:.5rem 1rem; color:#0F172A; font-size:.875rem; cursor:pointer; font-family:inherit; }
.no-results { text-align:center; padding:4rem; background:#FFFFFF; border:1px solid #E2E8F0; border-radius:20px; }
.pagination { display:flex; gap:.4rem; justify-content:center; flex-wrap:wrap; margin-top:2rem; }
.pagination a, .pagination span { padding:.5rem .85rem; border-radius:8px; font-size:.875rem; font-weight:500; text-decoration:none; }
.pagination a { background:#FFFFFF; border:1px solid #E2E8F0; color:#475569; transition:all .2s; }
.pagination a:hover { border-color:#4F46E5; color:#818CF8; }
.pagination span.active-page { background:#4F46E5; color:#fff; border:1px solid #4F46E5; }
.pagination span.disabled { background:#FFFFFF; border:1px solid #E2E8F0; color:#E2E8F0; }
@media(max-width:900px) { .cari-layout { grid-template-columns:1fr; } .filter-sidebar { position:static; } }
</style>
@endpush

@section('content')
<div class="cari-layout">
    <!-- SIDEBAR FILTER -->
    <aside class="filter-sidebar">
        <form action="{{ route('kost.index') }}" method="GET" id="filterForm">
            
            <div class="filter-card">
                <div class="filter-title"><i class="fa-solid fa-filter"></i> Harga</div>
                <div class="filter-body" style="padding-top: 2.5rem; padding-bottom: 0.5rem;">
                    <div id="katalog-price-slider"></div>
                    <div style="display: flex; justify-content: space-between; margin-top: 1.5rem; font-size: 0.85rem; font-weight: 600; color: #333;">
                        <span id="katalog_harga_min_display">Rp 0</span>
                        <span id="katalog_harga_max_display">Rp 3.000.000</span>
                    </div>
                    <input type="hidden" name="harga_min" id="katalog_harga_min_input" value="{{ $filters['harga_min'] ?? 0 }}">
                    <input type="hidden" name="harga_max" id="katalog_harga_max_input" value="{{ $filters['harga_max'] ?? 3000000 }}">
                </div>
            </div>

            <div class="filter-card">
                <div class="filter-title"><i class="fa-solid fa-list"></i> Kategori</div>
                <div class="filter-body">
                    <div class="filter-radio-group">
                        <label class="filter-radio"><input type="radio" name="tipe" value=""> Semua</label>
                        <label class="filter-radio"><input type="radio" name="tipe" value="putra" {{ ($filters['tipe'] ?? '') == 'putra' ? 'checked' : '' }}> Putra</label>
                        <label class="filter-radio"><input type="radio" name="tipe" value="putri" {{ ($filters['tipe'] ?? '') == 'putri' ? 'checked' : '' }}> Putri</label>
                        <label class="filter-radio"><input type="radio" name="tipe" value="campur" {{ ($filters['tipe'] ?? '') == 'campur' ? 'checked' : '' }}> Campur</label>
                    </div>
                </div>
            </div>

            <div class="filter-card">
                <div class="filter-title"><i class="fa-solid fa-map-marker-alt"></i> Jarak Kampus</div>
                <div class="filter-body">
                    <select name="jarak_max" class="filter-input">
                        <option value="">Semua Jarak</option>
                        @foreach([1,2,3,5,10] as $j)
                            <option value="{{ $j }}" {{ ($filters['jarak_max'] ?? '') == $j ? 'selected' : '' }}>≤ {{ $j }} km</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="filter-card">
                <div class="filter-title"><i class="fa-solid fa-check-square"></i> Fasilitas</div>
                <div class="filter-body">
                    <div class="filter-check-group">
                        @foreach(['fasilitas_ac'=>'AC','fasilitas_wifi'=>'WiFi','fasilitas_kamar_mandi_dalam'=>'KM Dalam','fasilitas_parkir_motor'=>'Parkir Motor','fasilitas_dapur'=>'Dapur','fasilitas_laundry'=>'Laundry'] as $k=>$v)
                            <label class="filter-check">
                                <input type="checkbox" name="{{ $k }}" value="1" {{ !empty($filters[$k]) ? 'checked' : '' }}> {{ $v }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="filter-btn"><i class="fa-solid fa-search"></i> Terapkan Pencarian</button>
            <a href="{{ route('kost.index') }}" class="reset-btn"><i class="fa-solid fa-rotate-left"></i> Reset</a>
        </form>
    </aside>

    <!-- KOST LIST -->
    <div class="kost-main">
        <div style="font-size: 1.15rem; font-weight: 500; color: #333; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.75rem;">
            Silahkan mencari kos sesuai keinginan anda..
        </div>
        
        <div class="kost-topbar">
            <div class="kost-count">
                Menampilkan <strong style="color:var(--primary);">{{ $kosts->firstItem() ?? 0 }}-{{ $kosts->lastItem() ?? 0 }}</strong> dari <strong>{{ $kosts->total() }}</strong> kost
            </div>
            <select class="sort-select" onchange="window.location='{{ route('kost.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(location.search)), sort: this.value})">
                <option value="terbaru" {{ $sortBy == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="harga_asc" {{ $sortBy == 'harga_asc' ? 'selected' : '' }}>Harga ↑</option>
                <option value="harga_desc" {{ $sortBy == 'harga_desc' ? 'selected' : '' }}>Harga ↓</option>
                <option value="rating" {{ $sortBy == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                <option value="jarak" {{ $sortBy == 'jarak' ? 'selected' : '' }}>Terdekat</option>
            </select>
        </div>

        @if($kosts->count())
            <div class="kost-grid">
                @foreach($kosts as $kost)
                    @include('components.kost-card', ['kost' => $kost])
                @endforeach
            </div>
            <!-- PAGINATION -->
            @if($kosts->hasPages())
            <div class="pagination">
                @if($kosts->onFirstPage())
                    <span class="disabled">← Prev</span>
                @else
                    <a href="{{ $kosts->previousPageUrl() }}">← Prev</a>
                @endif
                @foreach($kosts->getUrlRange(1, $kosts->lastPage()) as $page => $url)
                    @if($page == $kosts->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
                @if($kosts->hasMorePages())
                    <a href="{{ $kosts->nextPageUrl() }}">Next →</a>
                @else
                    <span class="disabled">Next →</span>
                @endif
            </div>
            @endif
        @else
            <div class="no-results">
                <div style="font-size:3rem;margin-bottom:1rem;">🔍</div>
                <h2 style="font-size:1.2rem;margin-bottom:.5rem;">Tidak ada kost yang ditemukan</h2>
                <p style="color:#64748B;">Coba ubah kata kunci atau filter pencarian Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var slider = document.getElementById('katalog-price-slider');
    var minInput = document.getElementById('katalog_harga_min_input');
    var maxInput = document.getElementById('katalog_harga_max_input');
    var minDisplay = document.getElementById('katalog_harga_min_display');
    var maxDisplay = document.getElementById('katalog_harga_max_display');

    noUiSlider.create(slider, {
        start: [minInput.value || 0, maxInput.value || 3000000],
        connect: true,
        step: 50000,
        range: {
            'min': 0,
            'max': 3000000
        },
        format: {
            to: function (value) { return Math.round(value); },
            from: function (value) { return Math.round(value); }
        }
    });

    slider.noUiSlider.on('update', function (values, handle) {
        if (handle) {
            maxInput.value = values[handle];
            maxDisplay.textContent = 'Rp ' + parseInt(values[handle]).toLocaleString('id-ID');
        } else {
            minInput.value = values[handle];
            minDisplay.textContent = 'Rp ' + parseInt(values[handle]).toLocaleString('id-ID');
        }
    });
});
</script>
@endpush
