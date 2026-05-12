@extends('layouts.app')

@section('title', 'Detail Barang')

@push('styles')
<style>
    .back-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .back-bar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: var(--radius);
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all .2s;
    }

    .back-btn:hover { border-color: var(--accent); color: var(--accent); }

    .back-bar-title {
        font-family: var(--font-head);
        font-size: 15px;
        font-weight: 700;
        color: var(--muted);
    }

    .back-bar-actions { display: flex; gap: 8px; }

    /* ── CARD ── */
    .detail-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    /* ── TOP SECTION ── */
    .detail-top {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 0;
        border-bottom: 1px solid var(--border);
    }

    /* Photo area */
    .photo-wrap {
        border-right: 1px solid var(--border);
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--surface2);
        min-height: 220px;
    }

    .photo-wrap img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--border);
    }

    .photo-placeholder {
        width: 160px;
        height: 160px;
        border-radius: 10px;
        border: 2px dashed var(--border);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--muted);
        font-size: 12px;
    }

    .photo-placeholder svg { opacity: .4; }

    /* Info area */
    .detail-info {
        padding: 28px 32px;
    }

    .item-name {
        font-family: var(--font-head);
        font-size: 26px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 10px;
        line-height: 1.2;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: rgba(0,212,255,.12);
        color: var(--accent);
        border: 1px solid rgba(0,212,255,.2);
        margin-bottom: 20px;
    }

    /* Stok status pill */
    .stok-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .stok-pill.ok      { background: rgba(46,213,115,.12); color: var(--success); border: 1px solid rgba(46,213,115,.25); }
    .stok-pill.menipis { background: rgba(255,165,2,.12);  color: var(--warning); border: 1px solid rgba(255,165,2,.25); }
    .stok-pill.habis   { background: rgba(255,71,87,.12);  color: var(--danger);  border: 1px solid rgba(255,71,87,.25); }

    .stok-pill .dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ── GRID FIELDS ── */
    .fields-grid {
        padding: 24px 32px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--border);
    }

    .field-cell {
        background: var(--surface);
        padding: 18px 20px;
    }

    .field-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .field-value {
        font-size: 16px;
        font-family: var(--font-head);
        font-weight: 700;
        color: var(--text);
    }

    .field-value.price     { color: var(--success); }
    .field-value.price-buy { color: var(--warning); }

    /* ── DESCRIPTION ── */
    .desc-section {
        padding: 22px 32px;
        border-top: 1px solid var(--border);
    }

    .desc-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--muted);
        margin-bottom: 10px;
    }

    .desc-text {
        font-size: 14px;
        color: var(--text);
        line-height: 1.7;
        opacity: .85;
    }

    .desc-empty {
        font-size: 13px;
        color: var(--muted);
        font-style: italic;
    }

    /* ── TIMESTAMPS ── */
    .timestamps {
        padding: 14px 32px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 24px;
        font-size: 11px;
        color: var(--muted);
    }
</style>
@endpush

@section('content')

<div class="back-bar">
    <div class="back-bar-left">
        <a href="{{ route('dashboard') }}" class="back-btn">← Kembali</a>
        <span class="back-bar-title">Detail Barang</span>
    </div>
    <div class="back-bar-actions">
        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-edit">Edit Barang</a>
        <button class="btn btn-danger" onclick="hapusBarang({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}')">Hapus</button>
    </div>
</div>

<div class="detail-card">

    {{-- TOP: foto + nama --}}
    <div class="detail-top">
        <div class="photo-wrap">
            {{--
                DB menyimpan: 'barang/namafile.jpg'
                File ada di:  public/barang/namafile.jpg
                URL:          asset('barang/namafile.jpg')  ✅
            --}}
            @if($barang->foto)
                <img
                    src="{{ asset($barang->foto) }}"
                    alt="{{ $barang->nama_barang }}"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >
                <div class="photo-placeholder" style="display:none;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Foto tidak ditemukan</span>
                </div>
            @else
                <div class="photo-placeholder">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span>Tidak ada foto</span>
                </div>
            @endif
        </div>

        <div class="detail-info">
            <div class="item-name">{{ $barang->nama_barang }}</div>
            <div class="badge">{{ $barang->kategori->nama_kategori }}</div>
            <br>
            @php
                $stokClass = $barang->stok == 0 ? 'habis'   : ($barang->stok < 20 ? 'menipis' : 'ok');
                $stokLabel = $barang->stok == 0 ? 'Stok Habis' : ($barang->stok < 20 ? 'Stok Menipis' : 'Stok Tersedia');
            @endphp
            <span class="stok-pill {{ $stokClass }}">
                <span class="dot"></span>
                {{ $stokLabel }}
            </span>
        </div>
    </div>

    {{-- FIELDS GRID --}}
    <div class="fields-grid">
        <div class="field-cell">
            <div class="field-label">Jumlah Stok</div>
            <div class="field-value">{{ $barang->stok }} {{ $barang->satuan }}</div>
        </div>
        <div class="field-cell">
            <div class="field-label">Stok Minimum</div>
            <div class="field-value">{{ $barang->stok_minimum ?? 0 }} {{ $barang->satuan }}</div>
        </div>
        <div class="field-cell">
            <div class="field-label">Harga Jual</div>
            <div class="field-value price">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</div>
        </div>
        <div class="field-cell">
            <div class="field-label">Harga Beli</div>
            <div class="field-value price-buy">
                {{ $barang->harga_beli ? 'Rp ' . number_format($barang->harga_beli, 0, ',', '.') : '—' }}
            </div>
        </div>
        <div class="field-cell">
            <div class="field-label">Berat / Ukuran</div>
            <div class="field-value">{{ $barang->berat_ukuran ?? '—' }}</div>
        </div>
        <div class="field-cell">
            <div class="field-label">Lokasi Simpan</div>
            <div class="field-value">{{ $barang->lokasi_simpan ?? '—' }}</div>
        </div>
    </div>

    {{-- DESCRIPTION --}}
    <div class="desc-section">
        <div class="desc-label">Deskripsi</div>
        @if($barang->deskripsi)
            <div class="desc-text">{{ $barang->deskripsi }}</div>
        @else
            <div class="desc-empty">Tidak ada deskripsi.</div>
        @endif
    </div>

    {{-- TIMESTAMPS --}}
    <div class="timestamps">
        <span>Ditambahkan: {{ $barang->created_at->format('d M Y, H:i') }}</span>
        <span>Terakhir diperbarui: {{ $barang->updated_at->format('d M Y, H:i') }}</span>
    </div>

</div>

@endsection