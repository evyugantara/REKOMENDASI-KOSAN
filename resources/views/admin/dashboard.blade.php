@extends('admin.layout')
@section('title', 'Dashboard')

@push('styles')
<style>
/* Small Box Black and White */
.row { display: flex; flex-wrap: wrap; margin-left: -0.75rem; margin-right: -0.75rem; margin-bottom: 1rem; }
.col-lg-3, .col-md-6, .col-12 { padding-left: 0.75rem; padding-right: 0.75rem; }
.col-lg-3 { width: 25%; }
.col-md-6 { width: 50%; }
.col-12 { width: 100%; }

.box { border-radius: 4px; color: #fff; padding: 0; position: relative; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
.box-body { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
.box-info { display: flex; flex-direction: column; }
.box-info h3 { font-size: 2.5rem; font-weight: 700; margin: 0; line-height: 1; }
.box-info p { font-size: 1rem; margin: 0.5rem 0 0 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
.box-icon { font-size: 4rem; opacity: 0.3; transition: transform 0.3s; }
.box:hover .box-icon { transform: scale(1.1); }
.box-footer { background: rgba(0,0,0,0.1); padding: 0.5rem 1rem; font-size: 0.85rem; color: #fff; text-decoration: none; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s; }
.box-footer:hover { background: rgba(0,0,0,0.15); color: #fff; }

.bg-blue { background-color: #3b82f6; }
.bg-green { background-color: #10b981; }
.bg-yellow { background-color: #f59e0b; }
.bg-red { background-color: #ef4444; }

.dashboard-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }

@media (max-width: 992px) { .dashboard-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px) { .dashboard-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('admin-content')
<div style="margin-bottom: 2rem;">
    <h2 style="font-size:1.5rem; margin-bottom: 0.25rem; font-weight: 400;">Selamat Datang,</h2>
    <h1 style="font-size:1.8rem; font-weight: 700; margin:0; text-transform: uppercase;">Admin Sistem Kost UNSUR</h1>
    <hr style="margin-top: 1rem; border:0; border-top:1px solid #dee2e6;">
</div>

<div class="dashboard-grid">
    <!-- BOX 1: Kost -->
    <div class="box bg-blue">
        <div class="box-body">
            <div class="box-info">
                <h3>{{ $stats['total_kost'] ?? 0 }}</h3>
                <p>Total Kost</p>
            </div>
            <div class="box-icon"><i class="fa-solid fa-building"></i></div>
        </div>
        <a href="{{ route('admin.kost.index') }}" class="box-footer">
            View Details <i class="fa-solid fa-arrow-circle-right"></i>
        </a>
    </div>

    <!-- BOX 2: Kost Aktif -->
    <div class="box bg-green">
        <div class="box-body">
            <div class="box-info">
                <h3>{{ $stats['kost_aktif'] ?? 0 }}</h3>
                <p>Kost Aktif</p>
            </div>
            <div class="box-icon"><i class="fa-solid fa-check-circle"></i></div>
        </div>
        <a href="{{ route('admin.kost.index') }}" class="box-footer">
            View Details <i class="fa-solid fa-arrow-circle-right"></i>
        </a>
    </div>

    <!-- BOX 3: Users -->
    <div class="box bg-yellow">
        <div class="box-body">
            <div class="box-info">
                <h3>{{ $stats['total_user'] ?? 0 }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="box-icon"><i class="fa-solid fa-users"></i></div>
        </div>
        <a href="{{ route('admin.users') }}" class="box-footer">
            View Details <i class="fa-solid fa-arrow-circle-right"></i>
        </a>
    </div>

    <!-- BOX 4: Ulasan -->
    <div class="box bg-red">
        <div class="box-body">
            <div class="box-info">
                <h3>{{ $stats['total_ulasan'] ?? 0 }}</h3>
                <p>Jumlah Supplier / Ulasan</p>
            </div>
            <div class="icon"><i class="fa-solid fa-comments"></i></div>
            <a href="{{ route('admin.ulasan') }}" class="small-box-footer">More info <i class="fa-solid fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kost Terbaru</h3>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kost</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kostTerbaru ?? [] as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ ucfirst($k->tipe) }}</td>
                            <td>Rp {{ number_format($k->harga_per_bulan,0,',','.') }}</td>
                            <td><span class="badge {{ $k->is_active ? 'badge-success' : 'badge-danger' }}">{{ $k->is_active ? 'Tersedia' : 'Penuh' }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center;">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ulasan Terbaru</h3>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pengguna</th>
                            <th>Kost</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ulasanTerbaru ?? [] as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->user->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($u->kost->nama, 20) }}</td>
                            <td>{{ $u->rating }}/5</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
