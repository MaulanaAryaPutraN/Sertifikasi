@extends('layouts.app')

@section('title', 'Bantuan')

@push('styles')
<style>
    .page-title {
        font-family: var(--font-head);
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .help-section {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px 26px;
        margin-bottom: 16px;
    }

    .help-section-title {
        font-family: var(--font-head);
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 16px;
    }

    .step-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 13.5px;
        color: var(--text);
        line-height: 1.6;
    }

    .step-num {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(0,212,255,.12);
        border: 1px solid rgba(0,212,255,.25);
        color: var(--accent);
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1px;
    }

    .note-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 16px;
        padding: 12px 14px;
        background: rgba(167,139,250,.07);
        border: 1px solid rgba(167,139,250,.2);
        border-radius: var(--radius);
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
    }

    .note-box .note-icon { font-size: 15px; flex-shrink: 0; margin-top: 1px; }

    /* DEVELOPER CARD */
    .dev-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-top: 8px;
    }

    .dev-card-header {
        background: var(--surface2);
        padding: 14px 26px;
        border-bottom: 1px solid var(--border);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--muted);
    }

    .dev-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--border);
    }

    .dev-cell {
        background: var(--surface);
        padding: 14px 26px;
    }

    .dev-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--muted);
        margin-bottom: 5px;
    }

    .dev-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }

    .dev-value a {
        color: var(--accent);
        text-decoration: none;
    }

    .dev-value a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

<div class="page-title">Panduan Penggunaan Sistem</div>

{{-- Tambah barang baru --}}
<div class="help-section">
    <div class="help-section-title">Cara menambah barang baru</div>
    <ol class="step-list">
        <li class="step-item">
            <span class="step-num">1</span>
            Buka halaman <strong>Dashboard</strong>, klik tombol <strong>+ Tambah Barang</strong> di kanan atas.
        </li>
        <li class="step-item">
            <span class="step-num">2</span>
            Unggah foto barang (opsional), lalu isi formulir: nama, kategori, satuan, jumlah stok, harga, dan lainnya.
        </li>
        <li class="step-item">
            <span class="step-num">3</span>
            Klik <strong>Simpan Barang</strong>. Barang akan muncul di daftar dashboard.
        </li>
    </ol>
</div>

{{-- Update stok --}}
<div class="help-section">
    <div class="help-section-title">Cara update stok barang masuk</div>
    <ol class="step-list">
        <li class="step-item">
            <span class="step-num">1</span>
            Temukan barang di dashboard menggunakan kolom pencarian atau filter kategori.
        </li>
        <li class="step-item">
            <span class="step-num">2</span>
            Klik tombol <strong>Edit</strong> pada baris barang tersebut.
        </li>
        <li class="step-item">
            <span class="step-num">3</span>
            Ubah nilai <strong>Jumlah stok</strong> sesuai kondisi saat ini, lalu klik <strong>Simpan Barang</strong>.
        </li>
    </ol>
</div>

{{-- Kelola kategori --}}
<div class="help-section">
    <div class="help-section-title">Cara mengelola kategori</div>
    <ol class="step-list">
        <li class="step-item">
            <span class="step-num">1</span>
            Buka halaman <strong>Kategori</strong> dari navigasi atas.
        </li>
        <li class="step-item">
            <span class="step-num">2</span>
            Tambah, edit, atau hapus kategori sesuai kebutuhan toko.
        </li>
        <li class="step-item">
            <span class="step-num">3</span>
            Menghapus kategori tidak akan menghapus barang — barang akan menjadi tidak berkategori.
        </li>
    </ol>

    <div class="note-box">
        <span class="note-icon">💡</span>
        Satuan barang bisa bebas sesuai kebutuhan — misalnya <strong>pcs</strong>, <strong>pack</strong>, <strong>box</strong>, <strong>kg</strong>, <strong>liter</strong>, dan lain-lain.
    </div>
</div>

{{-- Developer Info --}}
<div class="dev-card">
    <div class="dev-card-header">Informasi Developer</div>
    <div class="dev-grid">
        <div class="dev-cell">
            <div class="dev-label">Nama</div>
            <div class="dev-value">Maulana Arya Putra Nugraha</div>
        </div>
        <div class="dev-cell">
            <div class="dev-label">NIM</div>
            <div class="dev-value">2241720199</div>
        </div>
        <div class="dev-cell">
            <div class="dev-label">Kelas</div>
            <div class="dev-value">TI-4G</div>
        </div>
        <div class="dev-cell">
            <div class="dev-label">Alamat</div>
            <div class="dev-value">Jl. Marsose 31-H</div>
        </div>
        <div class="dev-cell">
            <div class="dev-label">Nomor Telepon</div>
            <div class="dev-value">082233617717</div>
        </div>
        <div class="dev-cell">
            <div class="dev-label">Email</div>
            <div class="dev-value"><a href="mailto:email@contoh.com">maulana150118@contoh.com</a></div>
        </div>
    </div>
</div>

@endsection