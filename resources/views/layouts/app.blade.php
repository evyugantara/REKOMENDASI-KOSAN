<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Kost UNSUR')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Black, White, Dark Blue Palette */
            --bg-body: #f8fafc; /* Very light gray to distinguish from pure white cards */
            --bg-white: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a; /* Black/Very Dark Gray */
            --text-muted: #64748b;
            
            --primary: #285b8c; /* Matched with Admin Topbar */
            --primary-hover: #1e456d;
            --primary-light: #eff6ff;
            
            --black: #000000;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; }
        
        /* Top Navigation */
        .navbar { background-color: var(--primary); padding: 0 5%; height: 75px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .nav-brand { font-size: 1.25rem; font-weight: 600; color: #ffffff; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; letter-spacing: 0.5px; }
        .nav-brand i { font-size: 1.8rem; }
        .nav-brand span { color: #93c5fd; font-weight: 400; }
        
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-link { color: #e2e8f0; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: all 0.2s; padding: 0.5rem 0; position: relative; }
        .nav-link:hover, .nav-link.active { color: #ffffff; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background-color: #ffffff; transition: width 0.3s; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        
        .nav-auth { display: flex; gap: 1rem; align-items: center; }
        .btn-nav-primary { background-color: #ffffff; color: var(--primary); padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1px solid transparent; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-nav-primary:hover { background-color: #f8fafc; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-nav-secondary { background-color: rgba(255,255,255,0.1); color: #ffffff; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; }
        .btn-nav-secondary:hover { background-color: rgba(255,255,255,0.2); border-color: #ffffff; }
        
        /* Global UI Elements */
        .container { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1rem; }
        
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; font-weight: 600; padding: 0.6rem 1.25rem; border-radius: 8px; cursor: pointer; border: 1px solid transparent; text-decoration: none; transition: all 0.2s; justify-content: center; }
        .btn-primary { background-color: var(--primary); color: #fff; border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25); }
        .btn-secondary { background-color: var(--bg-white); color: var(--text-main); border-color: var(--border-color); }
        .btn-secondary:hover { background-color: var(--bg-body); color: var(--primary); border-color: var(--primary); }
        .btn-black { background-color: var(--black); color: #fff; }
        .btn-black:hover { background-color: #333; transform: translateY(-2px); }
        
        .card { background: var(--bg-white); border: none; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem; transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
        .card-header { padding: 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: var(--bg-white); }
        .card-title { font-size: 1.25rem; font-weight: 700; margin: 0; color: var(--primary); display: flex; align-items: center; gap: 0.5rem; }
        .card-body { padding: 1.5rem; }
        
        /* Forms */
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main); font-size: 0.95rem; }
        .form-control, .form-input { width: 100%; padding: 0.85rem 1rem; font-size: 0.95rem; font-family: inherit; color: var(--text-main); background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; transition: all 0.2s; }
        .form-control:focus, .form-input:focus { border-color: var(--primary); outline: 0; box-shadow: 0 0 0 4px var(--primary-light); background-color: var(--bg-white); }
        
        /* Badges */
        .badge { padding: 0.4rem 0.85rem; font-size: 0.8rem; font-weight: 600; border-radius: 50px; display: inline-flex; align-items: center; gap: 0.3rem; }
        .badge-blue { background-color: var(--primary-light); color: var(--primary); border: 1px solid rgba(30, 58, 138, 0.2); }
        .badge-black { background-color: #f1f5f9; color: var(--black); border: 1px solid #cbd5e1; }
        
        /* Footer */
        .footer { background-color: var(--primary); color: #e2e8f0; padding: 2.5rem 5%; text-align: center; font-size: 0.95rem; margin-top: auto; }
        .footer strong { color: #ffffff; font-size: 1rem; display: block; margin-bottom: 0.5rem; }
        
        /* Layout Grid */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        
        /* Kost Card & Grid */
        .kost-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .kost-card { display: flex; flex-direction: column; background: var(--bg-white); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; text-decoration: none; color: var(--text-main); transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); position: relative; }
        .kost-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px rgba(0,0,0,0.08); border-color: #cbd5e1; }
        .kost-card-img { height: 180px; position: relative; overflow: hidden; background: #e2e8f0; }
        .kost-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .kost-card:hover .kost-card-img img { transform: scale(1.05); }
        .kost-type-badge { position: absolute; top: 12px; left: 12px; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; color: #fff; z-index: 2; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        .badge-putra { background: var(--primary); }
        .badge-putri { background: var(--black); }
        .badge-campur { background: #475569; }
        .kost-avail { position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); color: #fff; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.7rem; font-weight: 600; z-index: 2; border: 1px solid rgba(255,255,255,0.2); }
        
        .kost-card-body { padding: 1.25rem; display: flex; flex-direction: column; flex: 1; }
        .kost-card-name { font-size: 1.15rem; font-weight: 700; margin-bottom: 0.4rem; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .kost-card-address { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 0.4rem; }
        
        .kost-meta { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1rem; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.75rem; }
        .kost-price { font-size: 1.3rem; font-weight: 800; color: var(--primary); }
        .kost-rating { display: flex; align-items: center; gap: 0.25rem; font-size: 0.85rem; font-weight: 700; color: #f59e0b; }
        .kost-rating span { color: var(--text-muted); font-size: 0.75rem; font-weight: 500; }
        
        .kost-facilities { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
        .facility-chip { font-size: 0.7rem; padding: 0.25rem 0.5rem; background: var(--bg-body); border: 1px solid var(--border-color); border-radius: 4px; color: var(--text-muted); display: inline-flex; align-items: center; gap: 0.3rem; }
        
        .kost-distance { font-size: 0.8rem; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 0.4rem; margin-top: auto; }
        
        /* Header Pages */
        .page-title { font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; text-align: center; }
        .page-subtitle { font-size: 1rem; color: var(--text-muted); text-align: center; margin-bottom: 2rem; }
        
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .navbar { padding: 0 1rem; }
        }
    </style>
    @stack('styles')
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">
    
    <!-- TOP NAVIGATION (DARK BLUE) -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-brand">
            <i class="fa-solid fa-building-user"></i> Kost<span>UNSUR</span>
        </a>
        
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('kost.index') }}" class="nav-link {{ request()->routeIs('kost.index') ? 'active' : '' }}">Katalog Kost</a>
            <a href="{{ route('rekomendasi.index') }}" class="nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}"><i class="fa-solid fa-wand-magic-sparkles"></i> Sistem Cerdas</a>

        </div>
        
        <div class="nav-auth">
            @auth
                <div style="display: flex; align-items: center; gap: 1rem; color: #ffffff;">
                    <span style="font-weight: 600; font-size: 0.95rem;">
                        <i class="fa-solid fa-circle-user" style="margin-right: 0.25rem;"></i> {{ auth()->user()->name }}
                    </span>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-nav-secondary"><i class="fa-solid fa-shield-halved"></i> Admin Panel</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn-nav-secondary"><i class="fa-solid fa-gauge-high"></i> Dashboard Mahasiswa</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-nav-primary"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-nav-secondary">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav-primary">Daftar Sekarang</a>
            @endauth
        </div>
    </nav>

    <!-- MAIN CONTENT (WHITE/LIGHT BACKGROUND) -->
    <main style="flex: 1;">
        @yield('content')
    </main>
    
    <!-- FOOTER (DARK BLUE) -->
    <footer class="footer">
        <strong>&copy; {{ date('Y') }} Sistem Rekomendasi Kost Universitas Suryakancana.</strong>
        Platform pencarian kost modern yang menggunakan Algoritma <i>Content-Based Filtering</i> & <i>Cosine Similarity</i>.
    </footer>
    
    @stack('scripts')
</body>
</html>
