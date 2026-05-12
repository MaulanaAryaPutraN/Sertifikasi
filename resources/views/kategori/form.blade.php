@extends('layouts.app')

@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@push('styles')
<style>
    .back-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
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
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
    }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        max-width: 640px;
    }

    .form-section {
        padding: 24px 28px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 20px;
    }

    .field:last-child { margin-bottom: 0; }

    .field label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text);
    }

    .field label .req { color: var(--danger); }

    .input-field {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 10px 14px;
        color: var(--text);
        font-family: var(--font-body);
        font-size: 13.5px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        width: 100%;
    }

    .input-field:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(0,212,255,.08);
    }

    .input-field::placeholder { color: var(--muted); opacity: .7; }
    .input-field.is-invalid   { border-color: var(--danger); }

    textarea.input-field {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    .field-error {
        font-size: 11px;
        color: var(--danger);
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 28px;
        border-top: 1px solid var(--border);
        background: var(--surface2);
    }
</style>
@endpush

@section('content')

<div class="back-bar">
    <a href="{{ route('kategori.index') }}" class="back-btn">← Kembali</a>
    <span class="back-bar-title">{{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}</span>
</div>

<form
    method="POST"
    action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}"
>
    @csrf
    @if(isset($kategori)) @method('PUT') @endif

    <div class="form-card">
        <div class="form-section">

            <div class="field">
                <label>Nama kategori <span class="req">*</span></label>
                <input
                    type="text"
                    name="nama_kategori"
                    class="input-field @error('nama_kategori') is-invalid @enderror"
                    value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                    placeholder="Ayam"
                    autofocus
                >
                @error('nama_kategori')
                    <div class="field-error">⚠ {{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>Deskripsi (opsional)</label>
                <textarea
                    name="deskripsi"
                    class="input-field @error('deskripsi') is-invalid @enderror"
                    placeholder="Produk berbahan dasar ayam beku..."
                >{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <div class="field-error">⚠ {{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('kategori.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($kategori) ? '💾 Simpan Perubahan' : '✚ Simpan Kategori' }}
            </button>
        </div>
    </div>

</form>

@endsection