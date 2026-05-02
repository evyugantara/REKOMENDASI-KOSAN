@extends('admin.layout')
@section('title', 'Laporan Ulasan')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Ulasan Pengguna</h3>
    </div>
    <div class="card-body" style="padding: 0; overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Kost</th>
                    <th>Komentar & Rating</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ulasans as $u)
                <tr>
                    <td>{{ $ulasans->firstItem() + $loop->index }}</td>
                    <td>{{ $u->user->name }}</td>
                    <td>{{ $u->kost->nama }}</td>
                    <td>
                        <div style="color:#212529; font-size:1.1rem;">{{ str_repeat('★', $u->rating) }}{{ str_repeat('☆', 5 - $u->rating) }}</div>
                        <small style="color:#6c757d;">{{ $u->komentar ?: 'Tidak ada komentar' }}</small>
                    </td>
                    <td>
                        <span class="badge {{ $u->is_approved ? 'badge-success' : 'badge-danger' }}">{{ $u->is_approved ? 'Disetujui' : 'Menunggu' }}</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.ulasan.approve', $u) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-default">
                                <i class="fa-solid {{ $u->is_approved ? 'fa-times' : 'fa-check' }}"></i> {{ $u->is_approved ? 'Sembunyikan' : 'Setujui' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center; padding: 2rem;">Belum ada ulasan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem; border-top: 1px solid #dee2e6;">
        {{ $ulasans->links() }}
    </div>
</div>
@endsection
