@extends('admin.layout')
@section('title', 'Data Kost')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kost</h3>
        <div style="float: right;">
            <a href="{{ route('admin.kost.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Kost</a>
        </div>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kosts as $k)
                <tr>
                    <td>{{ $kosts->firstItem() + $loop->index }}</td>
                    <td><strong>{{ $k->nama }}</strong><br><small style="color:#6c757d;">{{ \Illuminate\Support\Str::limit($k->alamat, 40) }}</small></td>
                    <td style="text-transform: capitalize;">{{ $k->tipe }}</td>
                    <td>Rp {{ number_format($k->harga_per_bulan,0,',','.') }}</td>
                    <td><span class="badge {{ $k->is_active ? 'badge-success' : 'badge-danger' }}">{{ $k->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <a href="{{ route('kost.detail', $k) }}" target="_blank" class="btn btn-default" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.kost.edit', $k) }}" class="btn btn-default" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="{{ route('admin.kost.destroy', $k) }}" style="display:inline;" onsubmit="return confirm('Hapus data kost ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center; padding: 2rem;">Belum ada data kost</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem; border-top: 1px solid #dee2e6;">
        {{ $kosts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
