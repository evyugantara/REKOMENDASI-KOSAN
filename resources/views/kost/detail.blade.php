@extends('layouts.app')
@section('title', $kost->nama)
@section('meta_desc', Str::limit($kost->deskripsi, 160))
@push('styles')
<style>
.detail-layout { max-width:1280px; margin:0 auto; padding:2rem 1.5rem 4rem; display:grid; grid-template-columns:1fr 380px; gap:2rem; }
.detail-gallery { border-radius:20px; overflow:hidden; background:#FFFFFF; margin-bottom:1.5rem; }
.gallery-main { height:400px; overflow:hidden; position:relative; }
.gallery-main img { width:100%; height:100%; object-fit:cover; }
.gallery-thumbs { display:flex; gap:.5rem; padding:.75rem; overflow-x:auto; }
.gallery-thumb { width:80px; height:60px; border-radius:8px; overflow:hidden; flex-shrink:0; cursor:pointer; border:2px solid transparent; transition:border-color .2s; }
.gallery-thumb.active { border-color: var(--primary); }
.gallery-thumb img { width:100%; height:100%; object-fit:cover; }
.detail-card { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:20px; padding:1.75rem; margin-bottom:1.5rem; }
.detail-card-title { font-size:1rem; font-weight:700; color: var(--primary); margin-bottom:1.25rem; display:flex; align-items:center; gap:.5rem; padding-bottom:.75rem; border-bottom:1px solid #E2E8F0; }
.detail-kost-name { font-size:1.75rem; font-weight:800; margin-bottom:.5rem; }
.detail-meta { display:flex; flex-wrap:wrap; gap:.75rem; margin-bottom:1.25rem; }
.detail-meta-item { display:flex; align-items:center; gap:.4rem; font-size:.875rem; color:#64748B; }
.detail-meta-item strong { color:#0F172A; }
.detail-price { font-size:2rem; font-weight:800; color: var(--primary); }
.detail-price-sub { font-size:.85rem; color:#64748B; }
.fas-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(130px, 1fr)); gap:.75rem; }
.fas-item { display:flex; align-items:center; gap:.6rem; background: var(--primary-light); border:1px solid rgba(40,91,140,.2); border-radius:10px; padding:.6rem .8rem; font-size:.825rem; color:#475569; }
.fas-item i { color: var(--primary); width:16px; text-align:center; }
.detail-desc { color:#64748B; line-height:1.85; font-size:.9rem; }
/* SIDEBAR */
.detail-sidebar { }
.sidebar-sticky { position:sticky; top:90px; display:flex; flex-direction:column; gap:1.25rem; }
.contact-card { background: var(--primary-light); border:1px solid rgba(40,91,140,.2); border-radius:20px; padding:1.75rem; }
.contact-price { font-size:1.6rem; font-weight:800; color: var(--primary); margin-bottom:.25rem; }
.contact-owner { display:flex; align-items:center; gap:.75rem; margin:1rem 0; padding:1rem; background:#FFFFFF; border-radius:12px; }
.contact-avatar { width:42px; height:42px; border-radius:50%; background: var(--primary); color: #fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.1rem; }
.wa-btn-full { display:flex; align-items:center; justify-content:center; gap:.75rem; width:100%; padding:.9rem; font-size:1rem; background: var(--primary); color:#fff; border-radius:12px; text-decoration:none; font-weight:700; transition:all .3s; }
.wa-btn-full:hover { transform:translateY(-3px); box-shadow:0 10px 30px rgba(40,91,140,.35); background: var(--primary-hover); }
.map-card { background:#FFFFFF; border:1px solid #E2E8F0; border-radius:20px; overflow:hidden; }
.map-placeholder { height:220px; background:linear-gradient(135deg,#FFFFFF,#E2E8F0); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:.75rem; }
.map-btn { display:flex; align-items:center; gap:.5rem; background: var(--primary); color:#fff; padding:.75rem 1rem; border-radius:10px; text-decoration:none; font-size:.875rem; font-weight:600; transition:all .2s; width:calc(100% - 2rem); margin:1rem; justify-content:center; }
.map-btn:hover { background: var(--primary-hover); }
/* ULASAN */
.rating-summary { display:flex; gap:1.5rem; align-items:center; margin-bottom:1.5rem; }
.rating-big { text-align:center; }
.rating-big-num { font-size:3rem; font-weight:800; color:#FCD34D; line-height:1; }
.rating-big-stars { display:flex; gap:.1rem; margin-top:.25rem; color:#FCD34D; font-size:.9rem; }
.rating-big-count { font-size:.75rem; color:#64748B; margin-top:.25rem; }
.rating-bar-wrap { flex:1; display:flex; flex-direction:column; gap:.3rem; }
.rating-bar-row { display:flex; align-items:center; gap:.5rem; font-size:.75rem; color:#64748B; }
.rating-bar-row span { width:15px; }
.rating-bar-track { flex:1; height:6px; background:#E2E8F0; border-radius:3px; overflow:hidden; }
.rating-bar-fill { height:100%; border-radius:3px; background:linear-gradient(90deg,#F59E0B,#FCD34D); }
.ulasan-list { display:flex; flex-direction:column; gap:1rem; }
.ulasan-item { background:#F8FAFC; border:1px solid #E2E8F0; border-radius:14px; padding:1.1rem; }
.ulasan-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:.6rem; }
.ulasan-user { display:flex; align-items:center; gap:.6rem; }
.ulasan-avatar { width:32px; height:32px; border-radius:50%; background: var(--primary); color: #fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.8rem; }
.ulasan-name { font-size:.875rem; font-weight:600; }
.ulasan-date { font-size:.75rem; color:#64748B; }
.ulasan-stars { color:#FCD34D; font-size:.8rem; }
.ulasan-text { font-size:.875rem; color:#64748B; line-height:1.65; }
.ulasan-form { background:rgba(79,70,229,.06); border:1px solid rgba(79,70,229,.2); border-radius:16px; padding:1.25rem; margin-top:1.5rem; }
.star-rating { display:flex; gap:.4rem; margin-bottom:.75rem; flex-direction:row-reverse; justify-content:flex-end; }
.star-rating input { display:none; }
.star-rating label { color:#E2E8F0; font-size:1.5rem; cursor:pointer; transition:color .1s; }
.star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color:#FCD34D; }
.form-textarea { width:100%; background:#F1F5F9; border:1px solid #E2E8F0; border-radius:10px; padding:.75rem 1rem; color:#0F172A; font-family:inherit; font-size:.875rem; resize:vertical; min-height:80px; }
.form-textarea:focus { outline:none; border-color:#4F46E5; }
.kost-serupa { max-width:1280px; margin:0 auto; padding:0 1.5rem 4rem; }
@media(max-width:1024px) { .detail-layout { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div style="max-width:1280px;margin:0 auto;padding:2rem 1.5rem 0;">
    <nav style="display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:#64748B;margin-bottom:1.5rem;">
        <a href="{{ route('home') }}" style="color:#64748B;text-decoration:none;">Beranda</a>
        <i class="fa-solid fa-chevron-right fa-xs"></i>
        <a href="{{ route('kost.index') }}" style="color:#64748B;text-decoration:none;">Kost</a>
        <i class="fa-solid fa-chevron-right fa-xs"></i>
        <span style="color:#818CF8;">{{ $kost->nama }}</span>
    </nav>
</div>

<div class="detail-layout">
    <!-- MAIN -->
    <div>
        <!-- Gallery -->
        <div class="detail-gallery">
            <div class="gallery-main" id="galleryMain">
                <img src="{{ $kost->getFotoUtamaUrl() }}" alt="{{ $kost->nama }}" id="mainImg" onerror="this.src='https://placehold.co/800x400/1E293B/818CF8?text=KostUnsur'">
            </div>
            @if($kost->fotos->count())
            <div class="gallery-thumbs">
                <div class="gallery-thumb active" onclick="changeImg('{{ $kost->getFotoUtamaUrl() }}', this)">
                    <img src="{{ $kost->getFotoUtamaUrl() }}" alt="">
                </div>
                @foreach($kost->fotos as $foto)
                <div class="gallery-thumb" onclick="changeImg('{{ asset('storage/'.$foto->foto) }}', this)">
                    <img src="{{ asset('storage/'.$foto->foto) }}" alt="">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Info Utama -->
        <div class="detail-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1rem;">
                <div>
                    <div style="display:flex;gap:.5rem;margin-bottom:.5rem;">
                        <span class="kost-type-badge badge-{{ $kost->tipe }}">{{ $kost->getTipeLabel() }}</span>
                        @if($kost->kamar_tersedia > 0)
                            <span style="background: var(--primary-light);border:1px solid rgba(40,91,140,.3);color:var(--primary);padding:.25rem .6rem;border-radius:8px;font-size:.75rem;font-weight:600;">✓ Tersedia</span>
                        @else
                            <span style="background:#f1f5f9;border:1px solid #94a3b8;color:#475569;padding:.25rem .6rem;border-radius:8px;font-size:.75rem;font-weight:600;">Penuh</span>
                        @endif
                    </div>
                    <h1 class="detail-kost-name">{{ $kost->nama }}</h1>
                    <div class="detail-meta">
                        <div class="detail-meta-item"><i class="fa-solid fa-location-dot" style="color:var(--primary);"></i> {{ $kost->alamat }}</div>
                        <div class="detail-meta-item"><i class="fa-solid fa-route" style="color:var(--primary);"></i> {{ $kost->getJarakFormatted() }} dari kampus UNSUR</div>
                        <div class="detail-meta-item"><i class="fa-solid fa-star" style="color:#FCD34D;"></i> <strong>{{ number_format($kost->rating_rata,1) }}</strong> ({{ $kost->jumlah_ulasan }} ulasan)</div>
                        <div class="detail-meta-item"><i class="fa-solid fa-door-open" style="color:#F59E0B;"></i> {{ $kost->kamar_tersedia }}/{{ $kost->jumlah_kamar }} kamar tersedia</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div class="detail-price">{{ $kost->getHargaFormatted() }}</div>
                    <div class="detail-price-sub">per bulan</div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="detail-card">
            <div class="detail-card-title"><i class="fa-solid fa-align-left"></i> Deskripsi</div>
            <div class="detail-desc">{{ $kost->deskripsi }}</div>
        </div>

        <!-- Fasilitas -->
        <div class="detail-card">
            <div class="detail-card-title"><i class="fa-solid fa-list-check"></i> Fasilitas Lengkap</div>
            <div class="fas-grid">
                @foreach($kost->getFasilitasList() as $fas)
                    <div class="fas-item"><i class="fa-solid {{ $fas['icon'] }}"></i> {{ $fas['nama'] }}</div>
                @endforeach
                @if(empty($kost->getFasilitasList()))
                    <p style="color:#64748B;">Belum ada informasi fasilitas.</p>
                @endif
            </div>
        </div>

        <!-- Ulasan -->
        <div class="detail-card">
            <div class="detail-card-title"><i class="fa-solid fa-comments"></i> Ulasan Pengguna</div>
            @php
                $ulasansApproved = $kost->ulasans->where('is_approved', true);
                $ratingDist = [];
                for($r=5;$r>=1;$r--) {
                    $count = $ulasansApproved->where('rating', $r)->count();
                    $ratingDist[$r] = $count;
                }
            @endphp
            @if($ulasansApproved->count() > 0)
            <div class="rating-summary">
                <div class="rating-big">
                    <div class="rating-big-num">{{ number_format($kost->rating_rata, 1) }}</div>
                    <div class="rating-big-stars">
                        @for($i=1;$i<=5;$i++)
                            <i class="fa-{{ $i <= round($kost->rating_rata) ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <div class="rating-big-count">{{ $kost->jumlah_ulasan }} ulasan</div>
                </div>
                <div class="rating-bar-wrap">
                    @for($r=5;$r>=1;$r--)
                    <div class="rating-bar-row">
                        <span>{{ $r }}</span>
                        <i class="fa-solid fa-star fa-xs" style="color:#FCD34D;"></i>
                        <div class="rating-bar-track"><div class="rating-bar-fill" style="width:{{ $ulasansApproved->count() > 0 ? (($ratingDist[$r]/$ulasansApproved->count())*100) : 0 }}%;"></div></div>
                        <span>{{ $ratingDist[$r] }}</span>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="ulasan-list">
                @foreach($ulasansApproved->take(5) as $ulasan)
                <div class="ulasan-item">
                    <div class="ulasan-header">
                        <div class="ulasan-user">
                            <div class="ulasan-avatar">{{ strtoupper(substr($ulasan->user->name, 0, 1)) }}</div>
                            <div>
                                <div class="ulasan-name">{{ $ulasan->user->name }}</div>
                                <div class="ulasan-date">{{ $ulasan->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="ulasan-stars">
                            @for($i=1;$i<=5;$i++)<i class="fa-{{ $i<=$ulasan->rating?'solid':'regular' }} fa-star"></i>@endfor
                        </div>
                    </div>
                    @if($ulasan->komentar)
                    <div class="ulasan-text">{{ $ulasan->komentar }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
                <p style="color:#64748B;text-align:center;padding:1rem;">Belum ada ulasan untuk kost ini.</p>
            @endif

            <!-- Form Ulasan -->
            @auth
                @if(!$sudahUlasan)
                <div class="ulasan-form">
                    <div style="font-weight:700;margin-bottom:1rem;">Berikan Ulasan Anda</div>
                    <form action="{{ route('ulasan.store', $kost) }}" method="POST">
                        @csrf
                        <div style="margin-bottom:.75rem;">
                            <label style="font-size:.8rem;color:#64748B;display:block;margin-bottom:.4rem;">Rating</label>
                            <div class="star-rating">
                                @for($i=5;$i>=1;$i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}">★</label>
                                @endfor
                            </div>
                        </div>
                        <div style="margin-bottom:1rem;">
                            <textarea name="komentar" class="form-textarea" placeholder="Tulis ulasan Anda... (opsional)">{{ old('komentar') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="padding:.7rem 1.5rem;font-size:.875rem;">
                            <i class="fa-solid fa-paper-plane fa-xs"></i> Kirim Ulasan
                        </button>
                    </form>
                </div>
                @else
                    <div style="text-align:center;padding:1rem;color:#34D399;font-size:.875rem;"><i class="fa-solid fa-circle-check"></i> Anda sudah memberikan ulasan untuk kost ini.</div>
                @endif
            @else
                <div style="text-align:center;padding:1rem;color:#64748B;font-size:.875rem;">
                    <a href="{{ route('login') }}" style="color:#818CF8;">Login</a> untuk memberikan ulasan
                </div>
            @endauth
        </div>
    </div>

    <!-- SIDEBAR -->
    <aside class="detail-sidebar">
        <div class="sidebar-sticky">
            <div class="contact-card">
                <div class="contact-price">{{ $kost->getHargaFormatted() }}</div>
                <div style="font-size:.8rem;color:#64748B;">per bulan</div>
                <div class="contact-owner">
                    <div class="contact-avatar">{{ strtoupper(substr($kost->pemilik, 0, 1)) }}</div>
                    <div>
                        <div style="font-weight:600;font-size:.9rem;">{{ $kost->pemilik }}</div>
                        <div style="font-size:.75rem;color:#64748B;">Pemilik Kost</div>
                    </div>
                </div>
                <a href="https://wa.me/62{{ ltrim($kost->no_whatsapp, '0') }}?text=Halo%20{{ urlencode($kost->pemilik) }},%20saya%20tertarik%20dengan%20kost%20{{ urlencode($kost->nama) }}.%20Apakah%20masih%20ada%20kamar%20tersedia?" target="_blank" class="wa-btn-full">
                    <i class="fa-brands fa-whatsapp fa-lg"></i> Hubungi via WhatsApp
                </a>
                <div style="font-size:.75rem;color:#64748B;text-align:center;margin-top:.75rem;">
                    <i class="fa-solid fa-door-open fa-xs"></i> {{ $kost->kamar_tersedia }} kamar tersedia dari {{ $kost->jumlah_kamar }} total
                </div>
            </div>

            <!-- MAP -->
            <div class="map-card">
                <div class="map-placeholder" style="height: auto; padding: 2.5rem 1rem;">
                    <i class="fa-solid fa-map-location-dot" style="font-size:3rem;color:var(--primary);margin-bottom:0.5rem;"></i>
                    <div style="text-align:center;">
                        <div style="font-weight:700;margin-bottom:.25rem;font-size:1.1rem;">Lokasi Kost</div>
                        <div style="font-size:.85rem;color:#64748B;">{{ $kost->getJarakFormatted() }} dari kampus UNSUR</div>
                    </div>
                    <div id="user-distance-info" style="display:none; text-align:center; background: var(--primary-light); padding: 0.75rem; border-radius: 12px; border: 1px solid rgba(40,91,140,.2); width: 85%; margin-top: 1rem;">
                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--primary); margin-bottom: 0.2rem;"><i class="fa-solid fa-location-crosshairs"></i> Jarak dari Lokasi Anda Saat Ini:</div>
                        <div id="user-distance-val" style="font-size: 1.4rem; font-weight: 800; color: var(--text-main);">...</div>
                    </div>
                </div>
                
                <button type="button" onclick="cekLokasiSaya()" class="btn-secondary" id="btn-cek-lokasi" style="width:calc(100% - 2rem); margin: 0 1rem 1rem; justify-content:center; padding: 0.8rem; font-size: 0.85rem; background:#F1F5F9; border:1px solid #E2E8F0; color:#0F172A; border-radius: 10px; cursor: pointer;">
                    <i class="fa-solid fa-location-crosshairs"></i> Cek Jarak dari Posisi Saya
                </button>
                <a id="map-direction-btn" href="https://www.google.com/maps?q={{ $kost->latitude }},{{ $kost->longitude }}" target="_blank" class="map-btn" style="margin-top:0;">
                    <i class="fa-solid fa-map"></i> Buka di Google Maps
                </a>
            </div>

            <!-- REKOMENASI CTA -->
            @auth
            <div style="background:rgba(79,70,229,.1);border:1px solid rgba(79,70,229,.25);border-radius:16px;padding:1.25rem;text-align:center;">
                <div style="font-size:1.5rem;margin-bottom:.5rem;">🤖</div>
                <div style="font-weight:700;margin-bottom:.4rem;font-size:.9rem;">Ingin yang Lebih Cocok?</div>
                <div style="font-size:.8rem;color:#64748B;margin-bottom:.75rem;">Gunakan sistem rekomendasi cerdas kami</div>
                <a href="{{ route('rekomendasi.index') }}" style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(79,70,229,.2);color:#818CF8;padding:.5rem 1rem;border-radius:8px;text-decoration:none;font-size:.8rem;font-weight:600;">
                    <i class="fa-solid fa-wand-magic-sparkles fa-xs"></i> Coba Rekomendasi
                </a>
            </div>
            @endauth
        </div>
    </aside>
</div>

<!-- KOST SERUPA -->
@if($kostSerupa->count())
<div class="kost-serupa">
    <div class="section-header" style="margin-bottom: 2rem;">
        <div>
            <div class="section-title" style="font-size:1.8rem; font-weight: 400; color: #475569; text-align: center;">Daftar Kost Serupa</div>
        </div>
    </div>
    <div class="kost-grid">
        @foreach($kostSerupa as $k)
            @include('components.kost-card', ['kost' => $k])
        @endforeach
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function cekLokasiSaya() {
    if (navigator.geolocation) {
        let btn = document.getElementById('btn-cek-lokasi');
        let originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mendapatkan lokasi...';
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;
            let kostLat = {{ $kost->latitude }};
            let kostLng = {{ $kost->longitude }};
            
            // Haversine Formula Javascript
            let R = 6371; 
            let dLat = (kostLat - lat) * Math.PI / 180;
            let dLng = (kostLng - lng) * Math.PI / 180;
            let a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(lat * Math.PI / 180) * Math.cos(kostLat * Math.PI / 180) *
                    Math.sin(dLng/2) * Math.sin(dLng/2);
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            let d = R * c;
            
            document.getElementById('user-distance-info').style.display = 'block';
            document.getElementById('user-distance-val').innerText = d.toFixed(2) + ' km';
            
            let mapBtn = document.getElementById('map-direction-btn');
            mapBtn.href = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lng}&destination=${kostLat},${kostLng}`;
            mapBtn.innerHTML = '<i class="fa-solid fa-route"></i> Rute dari Lokasi Saya';
            
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Berhasil Dihitung';
            setTimeout(() => { btn.style.display = 'none'; }, 2500);
        }, function(error) {
            alert('Gagal mendapatkan lokasi. Pastikan izin lokasi (GPS) diaktifkan di browser perangkat Anda.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, { enableHighAccuracy: true });
    } else {
        alert('Browser Anda tidak mendukung fitur lokasi GPS.');
    }
}

function changeImg(url, el) {
    document.getElementById('mainImg').src = url;
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
</script>
@endpush
