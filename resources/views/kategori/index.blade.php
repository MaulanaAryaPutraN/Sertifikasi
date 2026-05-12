@extends('layouts.app')

@section('title', 'Kategori')

@push('styles')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .page-title {
        font-family: var(--font-head);
        font-size: 20px;
        font-weight: 700;
    }

    .search-bar {
        margin-bottom: 16px;
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
        width: 280px;
    }

    .input-field:focus { border-color: var(--accent); }
    .input-field::placeholder { color: var(--muted); }

    /* TABLE */
    .table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }

    thead th {
        background: var(--surface2);
        padding: 11px 16px;
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
        padding: 12px 16px;
        vertical-align: middle;
    }

    .jumlah-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(167,139,250,.12);
        color: #a78bfa;
        border: 1px solid rgba(167,139,250,.2);
    }

    .actions { display: flex; gap: 6px; }

    .table-footer {
        padding: 12px 16px;
        border-top: 1px solid var(--border);
        font-size: 12px;
        color: var(--muted);
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-title">Daftar Kategori</div>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<form method="GET" action="{{ route('kategori.index') }}" class="search-bar">
    <input
        type="text"
        name="search"
        class="input-field"
        placeholder="Cari kategori..."
        value="{{ request('search') }}"
        onchange="this.form.submit()"
    >
</form>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama kategori</th>
                <th>Jumlah barang</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $i => $k)
            <tr>
                <td style="color:var(--muted)">{{ $i + 1 }}</td>
                <td style="font-weight:600">{{ $k->nama_kategori }}</td>
                <td><span class="jumlah-badge">{{ $k->barang_count }} barang</span></td>
                <td style="color:var(--muted)">{{ $k->created_at->format('j M Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-sm btn-edit">Edit</a>
                        <button
                            class="btn btn-sm btn-danger"
                            onclick="hapusKategori({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')"
                        >Hapus</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:40px;color:var(--muted)">
                    Tidak ada kategori ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-footer">{{ $kategori->count() }} kategori terdaftar</div>
</div>

@endsection