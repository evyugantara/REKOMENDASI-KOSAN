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
            --bg-body: #ebedef;
            --bg-white: #ffffff;
            --border-color: #c8ced3;
            --text-main: #3c4b64;
            --text-muted: #768192;
            
            --sidebar-bg: #3c4b64;
            --sidebar-text: rgba(255,255,255,.8);
            --sidebar-hover: rgba(255,255,255,.05);
            --sidebar-active: #ffffff;
            --sidebar-active-bg: rgba(255,255,255,.05);
            
            --primary: #321fdb;
            --primary-hover: #2a1ab9;
            --primary-light: #eaedfc;
            --info: #3399ff;
            --warning: #f9b115;
            --danger: #e55353;
            --black: #000000;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; display: flex; min-height: 100vh; overflow-x: hidden; }
        
        /* Layout Structure */
        .sidebar { width: 256px; background-color: var(--sidebar-bg); color: var(--sidebar-text); display: flex; flex-direction: column; flex-shrink: 0; transition: transform 0.3s; z-index: 1001; }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        
        /* Topbar (WHITE) */
        .topbar { height: 56px; background-color: var(--bg-white); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem; flex-shrink: 0; z-index: 1000; }
        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .toggle-btn { background: transparent; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer; transition: color 0.2s; display: flex; align-items: center; justify-content: center; padding: 0.25rem; }
        .toggle-btn:hover { color: var(--text-main); }
        
        .breadcrumb { display: flex; gap: 0.5rem; font-size: 0.9rem; color: var(--text-muted); }
        .breadcrumb a { color: var(--text-main); text-decoration: none; font-weight: 500; }
        
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; color: var(--text-muted); }
        .topbar-right i { font-size: 1.1rem; cursor: pointer; transition: color 0.2s; }
        .topbar-right i:hover { color: var(--text-main); }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 0.9rem; }
        
        /* Sidebar Branding */
        .sidebar-brand { height: 56px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #ffffff; text-decoration: none; background: rgba(0,0,0,.2); letter-spacing: 0.5px; }
        .sidebar-brand i { margin-right: 0.5rem; font-size: 1.4rem; }
        
        /* Sidebar Navigation */
        .sidebar-nav { padding: 1rem 0; flex: 1; overflow-y: auto; }
        .nav-header { font-size: 0.8rem; color: rgba(255,255,255,.6); padding: 0.75rem 1rem; font-weight: 700; margin-top: 0.5rem; }
        .nav-item { display: flex; align-items: center; padding: 0.75rem 1rem; color: var(--sidebar-text); text-decoration: none; transition: all 0.2s; font-size: 0.95rem; }
        .nav-item i { width: 20px; text-align: center; margin-right: 1rem; font-size: 1rem; color: rgba(255,255,255,.6); }
        .nav-item:hover { background-color: var(--sidebar-hover); color: #ffffff; }
        .nav-item:hover i { color: #ffffff; }
        .nav-item.active { background-color: var(--sidebar-active-bg); color: var(--sidebar-active); border-left: 3px solid var(--primary); }
        .nav-item.active i { color: var(--primary); }
        
        /* Main Content Area */
        .content { flex: 1; padding: 2.5rem; overflow-y: auto; background-color: var(--bg-body); }
        
        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .sidebar { position: fixed; top: 0; left: -256px; height: 100vh; }
            .sidebar.show { transform: translateX(256px); }
            .content { padding: 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <i class="fa-solid fa-building-user"></i> Kost<b>UNSUR</b>
        </a>
        <nav class="sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            
            <div class="nav-header">FITUR</div>
            <a href="{{ route('rekomendasi.index') }}" class="nav-item {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Rekomendasi Cerdas
            </a>
            <a href="{{ route('kost.index') }}" class="nav-item">
                <i class="fa-solid fa-list"></i> Lihat Katalog Kost
            </a>
            
            <div class="nav-header">EXTRAS</div>
            <a href="#" onclick="document.getElementById('logout-form').submit()" class="nav-item">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </nav>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="toggle-btn" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="breadcrumb" style="margin-left: 1rem;">
                    <a href="#">Home</a> <span style="margin: 0 0.2rem;">/</span> 
                    <span style="color: var(--text-muted);">@yield('title', 'Dashboard')</span>
                </div>
            </div>
            
            <div class="topbar-right">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-list-ul"></i>
                <i class="fa-regular fa-envelope"></i>
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
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
                        confirmButtonColor: '#321fdb'
                    });
                </script>
            @endif
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#321fdb'
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
