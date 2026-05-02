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
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; height: 100vh; overflow: hidden; line-height: 1.6; }
        
        /* Sidebar */
        .sidebar { width: 256px; background-color: var(--sidebar-bg); display: flex; flex-direction: column; transition: all 0.3s; flex-shrink: 0; z-index: 1001; }
        .sidebar-brand { height: 56px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #ffffff; text-decoration: none; background: rgba(0,0,0,.2); letter-spacing: 0.5px; }
        .sidebar-brand i { margin-right: 0.5rem; font-size: 1.4rem; }
        
        .sidebar-menu { padding: 1rem 0; flex: 1; overflow-y: auto; }
        .nav-header { font-size: 0.8rem; color: rgba(255,255,255,.6); padding: 0.75rem 1rem; font-weight: 700; margin-top: 0.5rem; }
        .nav-item { display: flex; align-items: center; padding: 0.75rem 1rem; color: var(--sidebar-text); text-decoration: none; transition: all 0.2s; font-size: 0.95rem; }
        .nav-item i { width: 20px; text-align: center; margin-right: 1rem; font-size: 1rem; color: rgba(255,255,255,.6); }
        .nav-item:hover { background-color: var(--sidebar-hover); color: #ffffff; }
        .nav-item:hover i { color: #ffffff; }
        .nav-item.active { background-color: var(--sidebar-active-bg); color: var(--sidebar-active); border-left: 3px solid var(--primary); }
        .nav-item.active i { color: var(--primary); }
        
        /* Main Content */
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
        
        /* Content Area */
        .content { flex: 1; overflow-y: auto; padding: 1.5rem; background-color: var(--bg-body); }
        
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
            <i class="fa-solid fa-shield-halved"></i> CORE<b>UI</b>
        </a>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            
            <div class="nav-header">COMPONENTS</div>
            <a href="{{ route('admin.kost.index') }}" class="nav-item {{ request()->routeIs('admin.kost.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Data Kost
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Users
            </a>
            <a href="{{ route('admin.ulasan') }}" class="nav-item {{ request()->routeIs('admin.ulasan') ? 'active' : '' }}">
                <i class="fa-solid fa-comments"></i> Ulasan
            </a>
            
            <div class="nav-header">EXTRAS</div>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fa-solid fa-globe"></i> Publik Web
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
                <div class="breadcrumb" style="margin-left: 1rem;">
                    <a href="#">Home</a> <span style="margin: 0 0.2rem;">/</span> 
                    <span style="color: var(--text-muted);">@yield('title')</span>
                </div>
            </div>
            
            <div class="topbar-right">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-list-ul"></i>
                <i class="fa-regular fa-envelope"></i>
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            </div>
        </header>
        
        <main class="content">
            
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
