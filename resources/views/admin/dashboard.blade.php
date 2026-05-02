@extends('admin.layout')
@section('title', 'Dashboard')

@push('styles')
<style>
/* CoreUI Cards */
.c-card { border-radius: 6px; color: #fff; position: relative; overflow: hidden; display: flex; flex-direction: column; min-height: 140px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
.c-card-body { padding: 1.25rem; z-index: 2; position: relative; flex: 1; }
.c-card .dropdown { position: absolute; right: 1.25rem; top: 1.25rem; opacity: 0.8; cursor: pointer; }
.c-value { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.1rem; display: flex; align-items: center; gap: 0.5rem; }
.c-value span { font-size: 0.8rem; font-weight: 400; opacity: 0.8; }
.c-label { font-size: 0.95rem; opacity: 0.9; }
.c-card-primary { background-color: var(--primary); }
.c-card-info { background-color: var(--info); }
.c-card-warning { background-color: var(--warning); }
.c-card-danger { background-color: var(--danger); }
.c-chart { position: absolute; bottom: 0; left: 0; width: 100%; height: 60px; opacity: 0.4; }

.dashboard-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }

/* Large Chart Card */
.chart-card { background: #fff; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 1.5rem; }
.chart-header { padding: 1.25rem; display: flex; justify-content: space-between; align-items: flex-start; }
.chart-title { font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.2rem; }
.chart-subtitle { font-size: 0.85rem; color: var(--text-muted); }
.chart-actions { display: flex; gap: 0.5rem; }
.btn-group { display: flex; border-radius: 4px; overflow: hidden; border: 1px solid var(--border-color); }
.btn-group button { background: #fff; border: none; padding: 0.4rem 1rem; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; border-right: 1px solid var(--border-color); }
.btn-group button.active { background: #e4e5e6; color: var(--text-main); font-weight: 600; }
.btn-icon { background: var(--primary); color: #fff; border: none; padding: 0.4rem 1rem; border-radius: 4px; cursor: pointer; }

.chart-body { height: 300px; padding: 1rem; position: relative; }
.chart-svg { width: 100%; height: 100%; }

.chart-footer { display: grid; grid-template-columns: repeat(5, 1fr); text-align: center; border-top: 1px solid var(--border-color); background: #f8f9fa; }
.cf-item { padding: 1.25rem 1rem; }
.cf-label { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem; }
.cf-value { font-size: 1.1rem; font-weight: 700; color: var(--text-main); }
.cf-bar { height: 4px; border-radius: 2px; margin-top: 0.5rem; width: 100%; background: #e4e5e6; position: relative; }
.cf-bar span { position: absolute; left: 0; top: 0; height: 100%; border-radius: 2px; }

@media (max-width: 992px) { .dashboard-grid { grid-template-columns: repeat(2, 1fr); } .chart-footer { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 576px) { .dashboard-grid { grid-template-columns: 1fr; } .chart-footer { grid-template-columns: repeat(2, 1fr); } .chart-header { flex-direction: column; gap: 1rem; } }
</style>
@endpush

@section('admin-content')
<div style="margin-bottom: 2rem;">
    <h2 style="font-size:1.5rem; margin-bottom: 0.25rem; font-weight: 400;">Selamat Datang,</h2>
    <h1 style="font-size:1.8rem; font-weight: 700; margin:0; text-transform: uppercase;">Admin Sistem Kost UNSUR</h1>
    <hr style="margin-top: 1rem; border:0; border-top:1px solid #dee2e6;">
</div>

<div class="dashboard-grid">
    <!-- Card 1: Primary (Blue) -->
    <div class="c-card c-card-primary">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $stats['total_user'] ?? 0 }} <span>(Users)</span></div>
            <div class="c-label">Total Pengguna Terdaftar</div>
        </div>
        <div class="c-chart">
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:100%;"><polyline fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" points="0,20 20,15 40,25 60,10 80,18 100,5"></polyline></svg>
        </div>
    </div>

    <!-- Card 2: Info (Light Blue) -->
    <div class="c-card c-card-info">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $stats['total_kost'] ?? 0 }} <span>(Total)</span></div>
            <div class="c-label">Katalog Kost Tersedia</div>
        </div>
        <div class="c-chart">
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:100%;"><polyline fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" points="0,25 20,20 40,28 60,15 80,5 100,10"></polyline></svg>
        </div>
    </div>

    <!-- Card 3: Warning (Yellow) -->
    <div class="c-card c-card-warning">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $stats['kost_aktif'] ?? 0 }} <span>(Active)</span></div>
            <div class="c-label">Kost dengan Kamar Kosong</div>
        </div>
        <div class="c-chart">
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:100%;"><polyline fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" points="0,10 20,5 40,15 60,25 80,20 100,28"></polyline></svg>
        </div>
    </div>

    <!-- Card 4: Danger (Red) -->
    <div class="c-card c-card-danger">
        <div class="c-card-body">
            <div class="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></div>
            <div class="c-value">{{ $stats['total_ulasan'] ?? 0 }} <span>(Reviews)</span></div>
            <div class="c-label">Total Ulasan Masuk</div>
        </div>
        <div class="c-chart">
            <div style="display:flex;height:100%;align-items:flex-end;gap:4px;padding:0 10px;">
                <div style="flex:1;background:rgba(255,255,255,0.5);height:40%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:70%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:30%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:90%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:50%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:80%;"></div>
                <div style="flex:1;background:rgba(255,255,255,0.5);height:20%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="chart-card">
    <div class="chart-header">
        <div>
            <div class="chart-title">Traffic Pencarian Kost</div>
            <div class="chart-subtitle">January - {{ date('F Y') }}</div>
        </div>
        <div class="chart-actions">
            <div class="btn-group">
                <button>Day</button>
                <button class="active">Month</button>
                <button>Year</button>
            </div>
            <button class="btn-icon"><i class="fa-solid fa-cloud-arrow-down"></i></button>
        </div>
    </div>
    <div class="chart-body">
        <svg class="chart-svg" viewBox="0 0 1000 250" preserveAspectRatio="none">
            <!-- Grid lines -->
            <line x1="0" y1="50" x2="1000" y2="50" stroke="#ebedef" stroke-width="1" />
            <line x1="0" y1="100" x2="1000" y2="100" stroke="#ebedef" stroke-width="1" />
            <line x1="0" y1="150" x2="1000" y2="150" stroke="#ebedef" stroke-width="1" />
            <line x1="0" y1="200" x2="1000" y2="200" stroke="#ebedef" stroke-width="1" />
            <!-- Dashed line -->
            <line x1="0" y1="180" x2="1000" y2="180" stroke="#e55353" stroke-width="2" stroke-dasharray="5,5" />
            <!-- Area 1 (Green) -->
            <path d="M0,150 Q125,50 250,150 T500,100 T750,200 T1000,50 L1000,250 L0,250 Z" fill="rgba(46, 184, 92, 0.1)" />
            <path d="M0,150 Q125,50 250,150 T500,100 T750,200 T1000,50" fill="none" stroke="#2eb85c" stroke-width="2" />
            <!-- Area 2 (Blue) -->
            <path d="M0,50 Q125,250 250,200 T500,100 T750,50 T1000,100 L1000,250 L0,250 Z" fill="rgba(50, 31, 219, 0.1)" />
            <path d="M0,50 Q125,250 250,200 T500,100 T750,50 T1000,100" fill="none" stroke="#321fdb" stroke-width="2" />
        </svg>
    </div>
    <div class="chart-footer">
        <div class="cf-item">
            <div class="cf-label">Total Kost</div>
            <div class="cf-value">{{ $stats['total_kost'] ?? 0 }} Kost</div>
            <div class="cf-bar"><span style="width:100%; background:var(--info);"></span></div>
        </div>
        <div class="cf-item">
            <div class="cf-label">Aktif</div>
            <div class="cf-value">{{ $stats['kost_aktif'] ?? 0 }} Kost ({{ $stats['total_kost'] > 0 ? round(($stats['kost_aktif']/$stats['total_kost'])*100) : 0 }}%)</div>
            <div class="cf-bar"><span style="width:{{ $stats['total_kost'] > 0 ? round(($stats['kost_aktif']/$stats['total_kost'])*100) : 0 }}%; background:var(--success, #2eb85c);"></span></div>
        </div>
        <div class="cf-item">
            <div class="cf-label">Users</div>
            <div class="cf-value">{{ $stats['total_user'] ?? 0 }} Users</div>
            <div class="cf-bar"><span style="width:60%; background:var(--warning);"></span></div>
        </div>
        <div class="cf-item">
            <div class="cf-label">Reviews</div>
            <div class="cf-value">{{ $stats['total_ulasan'] ?? 0 }}</div>
            <div class="cf-bar"><span style="width:80%; background:var(--danger);"></span></div>
        </div>
        <div class="cf-item">
            <div class="cf-label">Bounce Rate</div>
            <div class="cf-value">40.15%</div>
            <div class="cf-bar"><span style="width:40%; background:var(--primary);"></span></div>
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
