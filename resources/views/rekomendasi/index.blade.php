@extends('layouts.app')
@section('title', 'Rekomendasi Kost Cerdas')
@section('meta_desc', 'Dapatkan rekomendasi kost terbaik menggunakan Content-Based Filtering, Cosine Similarity dan Haversine Formula.')
@push('styles')
<style>
.rekom-hero { text-align:center; padding: 4rem 1.5rem 2rem; }
.rekom-hero h1 { font-size:2.5rem; font-weight:800; margin-bottom:.75rem; color: var(--text-main); }
.rekom-hero h1 span { color: var(--primary); }
.rekom-hero p { color:#64748B; max-width:600px; margin:0 auto; line-height:1.8; }
.pref-form-wrap { max-width:900px; margin:0 auto; padding:0 1.5rem 4rem; }
.pref-form { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:24px; padding:2.5rem; }
.form-section { margin-bottom:2rem; }
.form-section-title { font-size:1rem; font-weight:700; color: var(--primary); margin-bottom:1.25rem; display:flex; align-items:center; gap:.5rem; padding-bottom:.75rem; border-bottom:1px solid #E2E8F0; }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.form-group { display:flex; flex-direction:column; gap:.5rem; }
.form-label { font-size:.85rem; font-weight:600; color:#64748B; }
.form-input { background:#F1F5F9; border:1px solid #E2E8F0; border-radius:10px; padding:.75rem 1rem; color:#0F172A; font-family:inherit; font-size:.9rem; transition:border-color .2s; }
.form-input:focus { outline:none; border-color: var(--primary); box-shadow:0 0 0 3px var(--primary-light); }
.form-select { background:#F1F5F9; border:1px solid #E2E8F0; border-radius:10px; padding:.75rem 1rem; color:#0F172A; font-family:inherit; font-size:.9rem; cursor:pointer; }
.form-select:focus { outline:none; border-color: var(--primary); }
.fasilitas-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:.75rem; }
.fasilitas-check { display:flex; align-items:center; gap:.75rem; background:#F1F5F9; border:1px solid #E2E8F0; border-radius:10px; padding:.75rem 1rem; cursor:pointer; transition:all .2s; }
.fasilitas-check:hover { border-color: var(--primary); background: var(--primary-light); }
.fasilitas-check input[type=checkbox] { display:none; }
.fasilitas-check .check-box { width:20px; height:20px; border-radius:6px; border:2px solid #E2E8F0; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .2s; }
.fasilitas-check input:checked ~ .check-box, .fasilitas-check.checked .check-box { background: var(--primary); border-color: var(--primary); }
.fasilitas-check.checked { border-color: var(--primary); background: var(--primary-light); }
.fasilitas-check-label { font-size:.85rem; font-weight:500; color:#475569; display:flex; align-items:center; gap:.4rem; }
.btn-submit { width:100%; padding:1rem; font-size:1rem; font-weight:700; border-radius:12px; }
.algo-info { background: var(--primary-light); border:1px solid var(--border-color); border-radius:16px; padding:1.5rem; margin-top:2rem; }
.algo-info-title { font-weight:700; color: var(--primary); margin-bottom:.75rem; display:flex; align-items:center; gap:.5rem; }
.algo-formula { background: var(--bg-white); border: 1px dashed var(--primary); border-radius:10px; padding:1rem; margin-top:.75rem; font-family:monospace; font-size:.85rem; color: var(--text-main); text-align:center; }
@media(max-width:600px) { .form-grid { grid-template-columns:1fr; } .rekom-hero h1 { font-size:1.8rem; } }
</style>
@endpush

@section('content')
<div class="rekom-hero">
    <div style="display:inline-flex;align-items:center;gap:.5rem;background:var(--primary-light);border:1px solid var(--primary);color:var(--primary);padding:.4rem 1rem;border-radius:20px;font-size:.8rem;font-weight:600;margin-bottom:1.5rem;">
        <i class="fa-solid fa-brain"></i> Content-Based Filtering
    </div>
    <h1>Sistem Rekomendasi <span>Kost Cerdas</span></h1>
    <p>Isi preferensi Anda dan biarkan algoritma Cosine Similarity bekerja untuk menemukan kost yang paling cocok.</p>
</div>

<div class="pref-form-wrap">
    <form action="{{ route('rekomendasi.simpan') }}" method="POST" id="prefForm">
        @csrf
        <div class="pref-form">
            <!-- HARGA -->
            <div class="form-section">
                <div class="form-section-title"><i class="fa-solid fa-dollar-sign"></i> Rentang Anggaran Sewa</div>
                
                <div style="padding: 1rem 1rem 3rem;">
                    <div id="price-slider"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga Minimum (Rp)</label>
                        <input type="text" id="harga_min_display" class="form-input" readonly style="background:#F8FAFC; color:#0F172A; border:1px solid #E2E8F0;">
                        <input type="hidden" name="harga_min" id="harga_min_input" value="{{ old('harga_min', $preferensi?->harga_min ?? 300000) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga Maksimum (Rp)</label>
                        <input type="text" id="harga_max_display" class="form-input" readonly style="background:#F8FAFC; color:#0F172A; border:1px solid #E2E8F0;">
                        <input type="hidden" name="harga_max" id="harga_max_input" value="{{ old('harga_max', $preferensi?->harga_max ?? 1500000) }}">
                    </div>
                </div>
                <div style="font-size: 0.8rem; color: #64748B; margin-top: 0.5rem; line-height: 1.6;">
                    <i class="fa-solid fa-circle-info"></i> Geser slider di atas untuk menentukan range harga kost yang Anda inginkan (misalnya 600.000 - 800.000). Sistem cerdas akan mencari kecocokan tertinggi di rentang harga tersebut.
                </div>
            </div>
            <!-- JARAK & TIPE -->
            <div class="form-section">
                <div class="form-section-title"><i class="fa-solid fa-map-location-dot"></i> Lokasi & Tipe</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Jarak Maksimal dari Kampus (km)</label>
                        <select name="jarak_max" class="form-select">
                            @foreach([1,2,3,5,10] as $jarak)
                                <option value="{{ $jarak }}" {{ ($preferensi?->jarak_max ?? 3) == $jarak ? 'selected' : '' }}>≤ {{ $jarak }} km</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe Kost</label>
                        <select name="tipe_kost" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="putra" {{ ($preferensi?->tipe_kost ?? '') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ ($preferensi?->tipe_kost ?? '') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ ($preferensi?->tipe_kost ?? '') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- FASILITAS -->
            <div class="form-section">
                <div class="form-section-title"><i class="fa-solid fa-list-check"></i> Fasilitas yang Dibutuhkan</div>
                <div class="fasilitas-grid">
                    @php
                    $fasilitasOptions = [
                        'butuh_ac' => ['icon'=>'fa-wind', 'label'=>'AC'],
                        'butuh_wifi' => ['icon'=>'fa-wifi', 'label'=>'WiFi'],
                        'butuh_kamar_mandi_dalam' => ['icon'=>'fa-shower', 'label'=>'KM Dalam'],
                        'butuh_parkir_motor' => ['icon'=>'fa-motorcycle', 'label'=>'Parkir Motor'],
                        'butuh_parkir_mobil' => ['icon'=>'fa-car', 'label'=>'Parkir Mobil'],
                        'butuh_dapur' => ['icon'=>'fa-utensils', 'label'=>'Dapur Bersama'],
                        'butuh_laundry' => ['icon'=>'fa-soap', 'label'=>'Laundry'],
                    ];
                    @endphp
                    @foreach($fasilitasOptions as $key => $opt)
                    <label class="fasilitas-check {{ ($preferensi?->$key ?? false) ? 'checked' : '' }}" id="lbl_{{ $key }}">
                        <input type="checkbox" name="{{ $key }}" value="1" {{ ($preferensi?->$key ?? false) ? 'checked' : '' }} onchange="toggleCheck('lbl_{{ $key }}')">
                        <div class="check-box"><i class="fa-solid fa-check fa-xs" style="color:#fff;display:{{ ($preferensi?->$key ?? false) ? 'block' : 'none' }}" id="chk_{{ $key }}"></i></div>
                        <div class="fasilitas-check-label"><i class="fa-solid {{ $opt['icon'] }} fa-xs" style="color:var(--primary);"></i> {{ $opt['label'] }}</div>
                    </label>
                    @endforeach
                </div>
            </div>

            @if($errors->any())
                <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:1rem;margin-bottom:1rem;">
                    @foreach($errors->all() as $e)
                        <div style="color:#FCA5A5;font-size:.85rem;"><i class="fa-solid fa-circle-xmark fa-xs"></i> {{ $e }}</div>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="btn-primary btn-submit">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Hitung Rekomendasi Sekarang
            </button>
        </div>
    </form>

    <div class="algo-info">
        <div class="algo-info-title"><i class="fa-solid fa-flask"></i> Cara Kerja Algoritma</div>
        <p style="color:#64748B;font-size:.875rem;line-height:1.7;">Sistem menggunakan <strong style="color:var(--primary);">Content-Based Filtering</strong> dengan menghitung kesamaan vektor preferensi Anda terhadap setiap kost menggunakan formula Cosine Similarity:</p>
        <div class="algo-formula">cos(θ) = (A · B) / (|A| × |B|)</div>
        <p style="color:#64748B;font-size:.8rem;margin-top:.75rem;">Di mana A = vektor preferensi fasilitas Anda, dan B = vektor fasilitas kost. Skor akhir merupakan kombinasi berbobot: Harga (30%) + Fasilitas (35%) + Jarak (20%) + Rating (15%).</p>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
<style>
.noUi-target { background: #E2E8F0; border: none; box-shadow: inset 0 1px 3px rgba(0,0,0,.3); }
.noUi-connect { background: var(--primary); }
.noUi-handle { border: 2px solid var(--primary); background: #FFFFFF; box-shadow: 0 0 10px rgba(40,91,140,.3); border-radius: 50%; }
.noUi-handle::before, .noUi-handle::after { display: none; }
.noUi-tooltip { background: #FFFFFF; color: #0F172A; border: 1px solid #E2E8F0; font-size: 0.75rem; padding: 0.2rem 0.5rem; border-radius: 6px; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
<script>
    var slider = document.getElementById('price-slider');
    var minInput = document.getElementById('harga_min_input');
    var maxInput = document.getElementById('harga_max_input');
    var minDisplay = document.getElementById('harga_min_display');
    var maxDisplay = document.getElementById('harga_max_display');

    noUiSlider.create(slider, {
        start: [{{ old('harga_min', $preferensi?->harga_min ?? 300000) }}, {{ old('harga_max', $preferensi?->harga_max ?? 1500000) }}],
        connect: true,
        step: 50000,
        tooltips: [true, true],
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
            maxDisplay.value = 'Rp ' + parseInt(values[handle]).toLocaleString('id-ID');
        } else {
            minInput.value = values[handle];
            minDisplay.value = 'Rp ' + parseInt(values[handle]).toLocaleString('id-ID');
        }
    });
</script>
<script>
function toggleCheck(lblId) {
    const lbl = document.getElementById(lblId);
    const cb = lbl.querySelector('input[type=checkbox]');
    const ico = lbl.querySelector('.fa-check');
    if (cb.checked) {
        lbl.classList.add('checked');
        if (ico) ico.style.display = 'block';
    } else {
        lbl.classList.remove('checked');
        if (ico) ico.style.display = 'none';
    }
}
</script>
@endpush
