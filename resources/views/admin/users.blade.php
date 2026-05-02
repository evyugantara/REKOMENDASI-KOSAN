@extends('admin.layout')
@section('title', 'Kelola Pengguna')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna (Mahasiswa & Admin)</h3>
    </div>
    <div class="card-body" style="padding: 0; overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>NPM / Prodi</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td style="text-transform: capitalize;">{{ $user->role }}</td>
                    <td>{{ $user->npm ?? '-' }} <br><small style="color:#6c757d;">{{ $user->prodi ?? '-' }}</small></td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center; padding: 2rem;">Belum ada data pengguna</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem; border-top: 1px solid #dee2e6;">
        {{ $users->links() }}
    </div>
</div>
@endsection
