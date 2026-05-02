@extends('admin.layout')
@php $isEdit = isset($kost); @endphp
@section('title', $isEdit ? 'Edit Kost' : 'Tambah Kost')

@push('styles')
<style>
.form-row { display: flex; flex-wrap: wrap; margin-left: -0.5rem; margin-right: -0.5rem; }
.form-col { flex: 1; padding: 0 0.5rem; min-width: 250px; }
.fasilitas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 0.75rem; }
.checkbox-custom { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; color: #212529; padding: 0.5rem; border: 1px solid #dee2e6; border-radius: 4px; transition: all 0.2s; }
.checkbox-custom:hover { background-color: #f8f9fa; }
.checkbox-custom input { accent-color: #212529; width: 16px; height: 16px; }
.section-title { font-size: 1.1rem; border-bottom: 2px solid #212529; padding-bottom: 0.5rem; margin-bottom: 1rem; margin-top: 1.5rem; font-weight: 600; color: #212529; }
</style>
@endpush

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $isEdit ? 'Form Edit Kost' : 'Form Tambah Kost' }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $isEdit ? route('admin.kost.update', $kost) : route('admin.kost.store') }}" enctype="multipart/form-data">
            @csrf
            @if($isEdit) @method('PUT') @endif
            
            <div class="section-title" style="margin-top:0;">Informasi Dasar</div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Nama Kost *</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $kost->nama ?? '') }}" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Tipe Kost *</label>
                        <select name="tipe" class="form-control" required>
                            @foreach(['putra'=>'Putra','putri'=>'Putri','campur'=>'Campur'] as $v=>$l)
                                <option value="{{ $v }}" {{ old('tipe', $kost->tipe ?? '') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Harga per Bulan (Rp) *</label>
                        <input type="number" name="harga_per_bulan" class="form-control" value="{{ old('harga_per_bulan', $kost->harga_per_bulan ?? '') }}" required min="0">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">No. WhatsApp *</label>
                        <input type="text" name="no_whatsapp" class="form-control" value="{{ old('no_whatsapp', $kost->no_whatsapp ?? '') }}" placeholder="Contoh: 08123456789" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Pemilik Kost *</label>
                        <input type="text" name="pemilik" class="form-control" value="{{ old('pemilik', $kost->pemilik ?? '') }}" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-row" style="margin:0;">
                        <div class="form-col" style="padding-left:0;">
                            <div class="form-group">
                                <label class="form-label">Total Kamar *</label>
                                <input type="number" name="jumlah_kamar" class="form-control" value="{{ old('jumlah_kamar', $kost->jumlah_kamar ?? '') }}" required min="1">
                            </div>
                        </div>
                        <div class="form-col" style="padding-right:0;">
                            <div class="form-group">
                                <label class="form-label">Kamar Tersedia *</label>
                                <input type="number" name="kamar_tersedia" class="form-control" value="{{ old('kamar_tersedia', $kost->kamar_tersedia ?? '') }}" required min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Lengkap *</label>
                <textarea name="deskripsi" class="form-control" style="min-height:100px; resize:vertical;" required>{{ old('deskripsi', $kost->deskripsi ?? '') }}</textarea>
            </div>

            <div class="section-title">Lokasi Kost</div>
            <div class="form-group">
                <label class="form-label">Alamat Lengkap *</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $kost->alamat ?? '') }}" required>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $kost->kelurahan ?? '') }}">
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $kost->kecamatan ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Latitude * <small style="font-weight:normal; color:#6c757d;">(Contoh: -6.8200)</small></label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $kost->latitude ?? '') }}" required>
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Longitude * <small style="font-weight:normal; color:#6c757d;">(Contoh: 107.1400)</small></label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $kost->longitude ?? '') }}" required>
                    </div>
                </div>
            </div>

            <div class="section-title">Fasilitas</div>
            <div class="fasilitas-grid">
                @foreach([
                    'fasilitas_ac'=>'AC', 'fasilitas_wifi'=>'WiFi', 'fasilitas_kamar_mandi_dalam'=>'KM Dalam',
                    'fasilitas_lemari'=>'Lemari', 'fasilitas_kasur'=>'Kasur', 'fasilitas_meja_kursi'=>'Meja & Kursi',
                    'fasilitas_parkir_motor'=>'Parkir Motor', 'fasilitas_parkir_mobil'=>'Parkir Mobil', 
                    'fasilitas_dapur'=>'Dapur Umum', 'fasilitas_laundry'=>'Laundry', 
                    'fasilitas_cctv'=>'CCTV', 'fasilitas_mushola'=>'Mushola'
                ] as $k=>$v)
                <label class="checkbox-custom">
                    <input type="checkbox" name="{{ $k }}" value="1" {{ old($k, $kost->$k ?? false) ? 'checked' : '' }}>
                    <span>{{ $v }}</span>
                </label>
                @endforeach
            </div>

            <div class="section-title">Foto & Status</div>
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Foto Utama {{ $isEdit ? '(kosongkan jika tidak diganti)' : '*' }}</label>
                        <input type="file" name="foto_utama" class="form-control" accept="image/*" {{ !$isEdit ? 'required' : '' }}>
                        @if($isEdit && $kost->foto_utama)
                            <img src="{{ $kost->getFotoUtamaUrl() }}" style="width:120px;margin-top:0.5rem;border:1px solid #dee2e6;border-radius:4px;">
                        @endif
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Foto Tambahan (Bisa lebih dari 1)</label>
                        <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                    </div>
                </div>
                @if($isEdit)
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Status Kost</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ ($kost->is_active ?? true) ? 'selected' : '' }}>Aktif / Tersedia</option>
                            <option value="0" {{ !($kost->is_active ?? true) ? 'selected' : '' }}>Nonaktif / Penuh</option>
                        </select>
                    </div>
                </div>
                @endif
            </div>
            
            @if($isEdit && $kost->fotos->count())
            <div class="form-group" style="margin-top:0.5rem;">
                <label class="form-label">Galeri Foto</label>
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    @foreach($kost->fotos as $foto)
                    <div style="position:relative;">
                        <img src="{{ asset('storage/'.$foto->foto) }}" style="width:80px;height:60px;object-fit:cover;border:1px solid #dee2e6;border-radius:4px;">
                        <button type="button" onclick="document.getElementById('hapus-foto-{{ $foto->id }}').submit()" style="position:absolute;top:-5px;right:-5px;background:#212529;color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:10px;cursor:pointer;"><i class="fa-solid fa-times"></i></button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="form-group" style="margin-top: 2rem; border-top: 1px solid #dee2e6; padding-top: 1.5rem;">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan Data</button>
                <a href="{{ route('admin.kost.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>

        @if($isEdit && $kost->fotos->count())
            @foreach($kost->fotos as $foto)
            <form id="hapus-foto-{{ $foto->id }}" method="POST" action="{{ route('admin.kost.hapusFoto', $foto) }}" style="display:none;" onsubmit="return confirm('Hapus foto ini?')">
                @csrf @method('DELETE')
            </form>
            @endforeach
        @endif
    </div>
</div>
@endsection
