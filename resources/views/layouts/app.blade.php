<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Frozeria Stock - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0f1117;
            --surface:   #181c27;
            --surface2:  #1e2333;
            --border:    #2a3047;
            --accent:    #00d4ff;
            --accent2:   #0099cc;
            --danger:    #ff4757;
            --warning:   #ffa502;
            --success:   #2ed573;
            --text:      #e8eaf0;
            --muted:     #8892a4;
            --font-head: 'Syne', sans-serif;
            --font-body: 'DM Sans', sans-serif;
            --radius:    10px;
            --shadow:    0 4px 24px rgba(0,0,0,0.4);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 56px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            font-family: var(--font-head);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .nav-brand span {
            color: var(--accent);
        }

        .nav-brand .dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }

        .nav-links {
            display: flex;
            gap: 4px;
            list-style: none;
        }

        .nav-links a {
            display: block;
            padding: 6px 16px;
            border-radius: var(--radius);
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 13px;
            transition: color .2s, background .2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--text);
            background: var(--surface2);
        }

        .nav-links a.active {
            color: var(--accent);
        }

        /* ── WRAPPER ── */
        .wrapper {
            flex: 1;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 28px 24px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 18px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(46,213,115,.12); border: 1px solid rgba(46,213,115,.3); color: var(--success); }
        .alert-danger  { background: rgba(255,71,87,.12);  border: 1px solid rgba(255,71,87,.3);  color: var(--danger);  }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: opacity .2s, transform .1s;
        }
        .btn:active { transform: scale(.97); }
        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { opacity: .85; }
        .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 6px; }
        .btn-info    { background: rgba(0,212,255,.15); color: var(--accent); border: 1px solid rgba(0,212,255,.3); }
        .btn-edit    { background: rgba(255,165,2,.15);  color: var(--warning); border: 1px solid rgba(255,165,2,.3); }
        .btn-danger  { background: rgba(255,71,87,.15);  color: var(--danger);  border: 1px solid rgba(255,71,87,.3); }
        .btn-info:hover   { background: rgba(0,212,255,.25); }
        .btn-edit:hover   { background: rgba(255,165,2,.25); }
        .btn-danger:hover { background: rgba(255,71,87,.25); }
        .btn-outline {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            text-align: center;
            padding: 16px;
            font-size: 12px;
            color: var(--muted);
        }

        /* ── MODAL HAPUS GLOBAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(3px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }

        .modal-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
            animation: modalIn .2s ease;
            overflow: hidden;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(.94) translateY(8px); }
            to   { opacity: 1; transform: scale(1)   translateY(0); }
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 22px 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal-warn-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            background: rgba(255,165,2,.15);
            border: 1px solid rgba(255,165,2,.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .modal-header-title {
            font-family: var(--font-head);
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .modal-body {
            padding: 16px 22px 20px;
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.65;
        }

        .modal-body strong {
            color: var(--text);
            font-weight: 600;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            background: var(--surface2);
        }
    </style>

    @stack('styles')
</head>
<body>

<nav>
    <a href="{{ route('dashboard') }}" class="nav-brand">
        <div class="dot"></div>
        Frozeria <span>Stock</span>
    </a>
    <ul class="nav-links">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">Kategori</a></li>
        <li><a href="{{ route('bantuan') }}" class="{{ request()->routeIs('bantuan') ? 'active' : '' }}">Bantuan</a></li>
    </ul>
</nav>

<div class="wrapper">
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">✕ {{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<footer>© {{ date('Y') }} Frozeria Stock · Sistem Manajemen Stok Frozen Food</footer>

{{-- MODAL HAPUS GLOBAL --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-warn-icon">⚠️</div>
            <div class="modal-header-title" id="modalJudul">Hapus data?</div>
        </div>
        <div class="modal-body">
            Data <strong id="namaHapus"></strong> akan dihapus secara
            permanen dari sistem. Tindakan ini tidak dapat dibatalkan.
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="tutupModal()">Batal</button>
            <form id="formHapus" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@stack('scripts')
<script>
    function hapusBarang(id, nama) {
        bukaModal('Hapus barang?', nama, '/barang/' + id);
    }

    function hapusKategori(id, nama) {
        bukaModal('Hapus kategori?', nama, '/kategori/' + id);
    }

    function bukaModal(judul, nama, action) {
        document.getElementById('modalJudul').textContent = judul;
        document.getElementById('namaHapus').textContent  = nama;
        document.getElementById('formHapus').action       = action;
        document.getElementById('modalHapus').classList.add('show');
    }

    function tutupModal() {
        document.getElementById('modalHapus').classList.remove('show');
    }

    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModal();
    });
</script>
</body>
</html>