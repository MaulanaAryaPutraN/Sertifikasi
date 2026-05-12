@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title {
        font-family: var(--font-head);
        font-size: 22px;
        font-weight: 700;
        color: var(--text);
    }

    .page-title small {
        font-family: var(--font-body);
        font-size: 12px;
        color: var(--muted);
        font-weight: 400;
        display: block;
        margin-top: 2px;
    }

    /* ── STAT CARDS ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
        transition: border-color .2s;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: var(--card-accent, var(--accent));
    }

    .stat-card:hover { border-color: var(--card-accent, var(--accent)); }

    .stat-card.menipis { --card-accent: var(--warning); }
    .stat-card.habis   { --card-accent: var(--danger);  }
    .stat-card.kategori{ --card-accent: #a78bfa; }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .stat-value {
        font-family: var(--font-head);
        font-size: 36px;
        font-weight: 800;
        color: var(--card-accent, var(--accent));
        line-height: 1;
    }

    .stat-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 6px;
    }

    /* ── TOOLBAR ── */
    .toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .search-wrap {
        display: flex;
        gap: 8px;
        flex: 1;
        min-width: 200px;
    }

    .input-field {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 9px 14px;
        color: var(--text);
        font-family: var(--font-body);
        font-size: 13px;
        outline: none;
        transition: border-color .2s;
    }

    .input-field:focus { border-color: var(--accent); }
    .input-field::placeholder { color: var(--muted); }

    .input-field.search { flex: 1; }

    select.input-field {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238892a4' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    /* ── TABLE ── */
    .table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        background: var(--surface2);
        padding: 11px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }

    tbody td {
        padding: 11px 14px;
        vertical-align: middle;
    }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: rgba(0,212,255,.12);
        color: var(--accent);
        border: 1px solid rgba(0,212,255,.2);
    }

    .stok-cell {
        font-family: var(--font-head);
        font-weight: 700;
        font-size: 15px;
    }

    .stok-ok      { color: var(--success); }
    .stok-menipis { color: var(--warning); }
    .stok-habis   { color: var(--danger);  }

    .actions { display: flex; gap: 6px; }

    /* ── PAGINATION ── */
    .paging-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-top: 1px solid var(--border);
        font-size: 12px;
        color: var(--muted);
    }

    .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
    }

    .pagination .page-item .page-link {
        display: block;
        padding: 5px 10px;
        border-radius: 6px;
        background: var(--surface2);
        border: 1px solid var(--border);
        color: var(--muted);
        text-decoration: none;
        font-size: 12px;
        transition: all .2s;
    }

    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover {
        background: var(--accent);
        color: #000;
        border-color: var(--accent);
        font-weight: 700;
    }

    .pagination .page-item.disabled .page-link {
        opacity: .4;
        pointer-events: none;
    }

    /* ── MODAL ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.7);
        backdrop-filter: blur(4px);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show { display: flex; }

    .modal-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 32px;
        max-width: 400px;
        width: 90%;
        box-shadow: var(--shadow);
        animation: fadeUp .25s ease;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-icon {
        width: 52px; height: 52px;
        background: rgba(255,71,87,.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 22px;
    }

    .modal-title {
        font-family: var(--font-head);
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 8px;
    }

    .modal-desc {
        font-size: 13px;
        color: var(--muted);
        text-align: center;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .modal-desc strong { color: var(--text); }

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .modal-actions .btn {
        min-width: 110px;
        justify-content: center;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">
            Dashboard
            <small>Manajemen stok frozen food Frozeria</small>
        </div>
    </div>
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        + Tambah Barang
    </a>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Barang</div>
        <div class="stat-value">{{ $totalBarang }}</div>
        <div class="stat-sub">item terdaftar</div>
    </div>
    <div class="stat-card kategori">
        <div class="stat-label">Total Kategori</div>
        <div class="stat-value" style="color:#a78bfa">{{ $totalKategori }}</div>
        <div class="stat-sub">jenis kategori</div>
    </div>
    <div class="stat-card menipis">
        <div class="stat-label">Stok Menipis</div>
        <div class="stat-value">{{ $stokMenipis }}</div>
        <div class="stat-sub">stok < 20 unit</div>
    </div>
    <div class="stat-card habis">
        <div class="stat-label">Stok Habis</div>
        <div class="stat-value">{{ $stokHabis }}</div>
        <div class="stat-sub">stok = 0 unit</div>
    </div>
</div>

{{-- TOOLBAR --}}
<form method="GET" action="{{ route('dashboard') }}" id="filterForm">
    <div class="toolbar">
        <div class="search-wrap">
            <input
                type="text"
                name="search"
                class="input-field search"
                placeholder="Cari nama barang..."
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
        <select name="kategori_id" class="input-field" style="width:180px" onchange="document.getElementById('filterForm').submit()">
            <option value="">Semua kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
</form>

{{-- TABLE --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $index => $item)
            <tr>
                <td style="color:var(--muted)">{{ $barang->firstItem() + $index }}</td>
                <td style="font-weight:500">{{ $item->nama_barang }}</td>
                <td><span class="badge">{{ $item->kategori->nama_kategori }}</span></td>
                <td>
                    <span class="stok-cell {{ $item->stok == 0 ? 'stok-habis' : ($item->stok < 20 ? 'stok-menipis' : 'stok-ok') }}">
                        {{ $item->stok }}
                    </span>
                </td>
                <td style="color:var(--muted)">{{ $item->satuan }}</td>
                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('barang.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-edit">Edit</a>
                        <button
                            class="btn btn-sm btn-danger"
                            onclick="hapusBarang({{ $item->id }}, '{{ addslashes($item->nama_barang) }}')"
                        >Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                    Tidak ada barang yang ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paging-wrap">
        <span>Menampilkan {{ $barang->firstItem() }}–{{ $barang->lastItem() }} dari {{ $barang->total() }} barang</span>
        {{ $barang->links('vendor.pagination.custom') }}
    </div>
</div>

@endsection