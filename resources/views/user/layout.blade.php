<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Panel - Sistem Kost UNSUR')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-white: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            
            --sidebar-bg: #333333;
            --sidebar-text: #e5e5e5;
            --sidebar-hover: #404040;
            --sidebar-active: #ffffff;
            --sidebar-active-bg: #1e3a8a;
            
            --primary: #285b8c;
            --primary-hover: #1e456d;
            --primary-light: #eff6ff;
            --black: #000000;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; display: flex; min-height: 100vh; overflow-x: hidden; }
        
        /* Layout Structure */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); color: var(--sidebar-text); display: flex; flex-direction: column; flex-shrink: 0; transition: transform 0.3s; z-index: 1000; }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        
        /* Topbar */
        .topbar { height: 75px; background-color: var(--primary); border-bottom: none; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 1000; color: #fff; }
        .topbar h1 { font-size: 1.25rem; font-weight: 600; margin: 0; position: absolute; left: 50%; transform: translateX(-50%); }
        .toggle-btn { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; font-size: 1.25rem; color: #ffffff; cursor: pointer; transition: background 0.2s; }
        .toggle-btn:hover { background: rgba(255,255,255,0.2); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; font-size: 0.95rem; font-weight: 600; color: #ffffff; }
        
        /* Sidebar Branding */
        .sidebar-brand { height: 75px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; color: #ffffff; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05); letter-spacing: 1px; }
        .sidebar-brand i { color: #93c5fd; margin-right: 0.5rem; font-size: 1.8rem; }
        
        /* Sidebar Navigation */
        .sidebar-nav { padding: 1.5rem 1rem; flex: 1; overflow-y: auto; }
        .nav-item { display: flex; align-items: center; padding: 0.85rem 1rem; color: var(--sidebar-text); text-decoration: none; border-radius: 10px; margin-bottom: 0.5rem; transition: all 0.2s; font-weight: 500; font-size: 0.95rem; }
        .nav-item i { width: 24px; font-size: 1.1rem; text-align: center; margin-right: 0.75rem; color: #94a3b8; transition: color 0.2s; }
        .nav-item:hover { background-color: var(--sidebar-hover); color: #ffffff; transform: translateX(5px); }
        .nav-item:hover i { color: #ffffff; }
        .nav-item.active { background-color: var(--sidebar-active-bg); color: var(--sidebar-active); font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .nav-item.active i { color: #ffffff; }
        
        .sidebar-footer { padding: 1.5rem 1rem; border-top: 1px solid rgba(255,255,255,0.05); }
        .logout-btn { width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: rgba(239,68,68,0.1); color: #fca5a5; border: 1px solid rgba(239,68,68,0.2); padding: 0.75rem; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 0.95rem; text-decoration: none; }
        .logout-btn:hover { background-color: rgba(239,68,68,0.2); color: #f87171; border-color: rgba(239,68,68,0.3); }
        
        /* Main Content Area */
        .content { flex: 1; padding: 2.5rem; overflow-y: auto; background-color: var(--bg-body); }
        
        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .sidebar { position: fixed; top: 0; left: -260px; height: 100vh; }
            .sidebar.show { transform: translateX(260px); }
            .topbar h1 { display: none; }
            .content { padding: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <i class="fa-solid fa-building-user"></i> Kost UNSUR
        </a>
        <nav class="sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('rekomendasi.index') }}" class="nav-item {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Rekomendasi Cerdas
            </a>
            <a href="{{ route('kost.index') }}" class="nav-item">
                <i class="fa-solid fa-list"></i> Lihat Katalog Kost
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
            </form>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="toggle-btn" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <h1>Panel Mahasiswa / Pencari Kost</h1>
            <div class="topbar-right">
                <div style="background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 50px; display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-circle-user" style="font-size: 1.2rem;"></i>
                    {{ auth()->user()->name ?? 'User' }}
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="content">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#285b8c'
                    });
                </script>
            @endif
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#285b8c'
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
