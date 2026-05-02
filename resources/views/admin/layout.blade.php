<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel Kost UNSUR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Unified Palette: Black, White, Dark Blue */
            --bg-body: #f8fafc;
            --bg-white: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            
            --sidebar-bg: #333333; /* Dark Gray from Image 1 */
            --sidebar-text: #e5e5e5;
            --sidebar-hover: #404040;
            --sidebar-active: #ffffff;
            --sidebar-active-bg: #1e3a8a;
            
            --primary: #285b8c; /* Dark Blue from Image 1 Topbar */
            --primary-hover: #1e40af;
            --primary-light: #eff6ff;
            --black: #000000;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; line-height: 1.6; }
        
        /* Sidebar */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); display: flex; flex-direction: column; transition: all 0.3s; flex-shrink: 0; z-index: 1001; }
        .sidebar-brand { height: 75px; display: flex; align-items: center; padding: 0 1.5rem; font-size: 1.4rem; font-weight: 800; color: #ffffff; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05); letter-spacing: 0.5px; }
        .sidebar-brand i { color: #93c5fd; margin-right: 0.75rem; font-size: 1.6rem; }
        
        .sidebar-user { display: flex; align-items: center; padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); gap: 1rem; }
        .sidebar-user-avatar { width: 45px; height: 45px; border-radius: 50%; background-color: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; border: 2px solid rgba(255,255,255,0.2); }
        .sidebar-user-info { display: flex; flex-direction: column; }
        .sidebar-user-info strong { color: #fff; font-weight: 600; font-size: 0.95rem; }
        .sidebar-user-info small { color: #10b981; font-size: 0.75rem; font-weight: 600; } /* green status */
        
        .sidebar-menu { padding: 1rem 0.75rem; flex: 1; overflow-y: auto; }
        .nav-header { font-size: 0.75rem; text-transform: uppercase; color: var(--sidebar-text); padding: 0.5rem 0.75rem; font-weight: 700; margin-top: 1rem; letter-spacing: 1px; }
        .nav-item { display: flex; align-items: center; padding: 0.8rem 1rem; color: var(--sidebar-text); text-decoration: none; border-radius: 8px; margin-bottom: 0.3rem; transition: all 0.2s; font-size: 0.95rem; font-weight: 500; }
        .nav-item i { width: 25px; text-align: center; margin-right: 0.75rem; font-size: 1.1rem; }
        .nav-item:hover { background-color: var(--sidebar-hover); color: #ffffff; transform: translateX(3px); }
        .nav-item.active { background-color: var(--sidebar-active-bg); color: var(--sidebar-active); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        /* Main Content */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        
        /* Topbar (DARK BLUE) */
        .topbar { height: 75px; background-color: var(--primary); border-bottom: none; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 1000; color: #fff; }
        .topbar h1 { font-size: 1.25rem; font-weight: 600; margin: 0; position: absolute; left: 50%; transform: translateX(-50%); }
        .toggle-btn { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; font-size: 1.25rem; color: #ffffff; cursor: pointer; transition: background 0.2s; }
        .toggle-btn:hover { background: rgba(255,255,255,0.2); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; font-size: 0.95rem; font-weight: 600; color: #ffffff; }
        
        /* Content Area (WHITE/LIGHT GRAY) */
        .content { flex: 1; overflow-y: auto; padding: 2.5rem; background-color: var(--bg-body); }
        
        .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; }
        .page-title { font-size: 1.75rem; font-weight: 800; margin: 0; color: var(--primary); letter-spacing: -0.5px; }
        .breadcrumb { display: flex; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); font-weight: 500; margin-top: 0.25rem; }
        .breadcrumb a { color: var(--primary); text-decoration: none; }
        
        /* Cards */
        .card { background-color: var(--bg-white); border: 1px solid var(--border-color); border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,.02); margin-bottom: 2rem; overflow: hidden; transition: box-shadow 0.2s; }
        .card:hover { box-shadow: 0 10px 15px rgba(0,0,0,.05); }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: var(--bg-white); }
        .card-title { font-size: 1.15rem; font-weight: 700; margin: 0; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; }
        .card-body { padding: 1.5rem; }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 600; padding: 0.6rem 1.25rem; border-radius: 8px; cursor: pointer; border: 1px solid transparent; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background-color: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 2px 4px rgba(30, 58, 138, 0.1); }
        .btn-primary:hover { background-color: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(30, 58, 138, 0.2); }
        .btn-default { background-color: #ffffff; color: var(--text-main); border-color: var(--border-color); }
        .btn-default:hover { background-color: var(--bg-body); color: var(--primary); border-color: var(--primary); }
        .btn-danger { background-color: #fef2f2; color: #dc2626; border-color: #fca5a5; }
        .btn-danger:hover { background-color: #dc2626; color: #fff; }
        
        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 1rem 1.25rem; vertical-align: middle; border-bottom: 1px solid var(--border-color); text-align: left; font-size: 0.95rem; }
        .table th { font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; background: #f8fafc; }
        .table tbody tr:hover { background-color: #f1f5f9; }
        
        /* Form Global */
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main); font-size: 0.95rem; }
        .form-input, .form-control { width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; font-family: inherit; color: var(--text-main); background-color: #f8fafc; border: 2px solid var(--border-color); border-radius: 8px; transition: all 0.2s; }
        .form-control:focus, .form-input:focus { border-color: var(--primary); outline: 0; box-shadow: 0 0 0 3px var(--primary-light); background-color: var(--bg-white); }
        
        .badge { padding: 0.35rem 0.75rem; font-size: 0.75rem; font-weight: 600; border-radius: 50px; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-danger { background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        @media (max-width: 768px) {
            .sidebar { position: absolute; height: 100%; transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .content { padding: 1.5rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <i class="fa-solid fa-shield-halved"></i> Admin Panel
        </a>
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                <small><i class="fa-solid fa-circle" style="font-size: 6px; margin-right: 2px; vertical-align: middle;"></i> Online</small>
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="nav-header">Manajemen Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.kost.index') }}" class="nav-item {{ request()->routeIs('admin.kost.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Data Kost
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Pengguna
            </a>
            <a href="{{ route('admin.ulasan') }}" class="nav-item {{ request()->routeIs('admin.ulasan') ? 'active' : '' }}">
                <i class="fa-solid fa-comments"></i> Ulasan
            </a>
            
            <div class="nav-header">Pengaturan</div>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fa-solid fa-globe"></i> Website Publik
            </a>
            <a href="#" onclick="document.getElementById('logout-form').submit()" class="nav-item">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <button class="toggle-btn" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <h1>Sistem Informasi Kost Berbasis Rekomendasi Cerdas</h1>
            <div class="topbar-right">
                <div style="background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 50px; display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fa-solid fa-circle-user" style="font-size: 1.2rem;"></i>
                    {{ auth()->user()->name ?? 'Admin' }}
                </div>
            </div>
        </header>
        
        <main class="content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">@yield('title')</h1>
                    <div class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-home"></i> Home</a> 
                        <span style="color:var(--text-muted);">/</span> @yield('title')
                    </div>
                </div>
            </div>
            
            @if(session('success'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:1rem 1.5rem;border-radius:12px;margin-bottom:1.5rem;font-size:0.95rem;display:flex;align-items:center;gap:0.75rem;box-shadow:0 2px 4px rgba(22,101,52,0.05);">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:1rem 1.5rem;border-radius:12px;margin-bottom:1.5rem;font-size:0.95rem;box-shadow:0 2px 4px rgba(153,27,27,0.05);">
                    <strong style="display:block;margin-bottom:0.5rem;"><i class="fa-solid fa-circle-exclamation"></i> Terdapat Kesalahan:</strong>
                    <ul style="margin-left:1.5rem;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('admin-content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
