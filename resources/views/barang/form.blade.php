@extends('layouts.app')

@section('title', isset($barang) ? 'Edit Barang' : 'Tambah Barang Baru')

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

    /* ── FORM CARD ── */
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    .form-section {
        padding: 24px 28px;
        border-bottom: 1px solid var(--border);
    }

    .form-section:last-child { border-bottom: none; }

    .section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--muted);
        margin-bottom: 16px;
    }

    /* ── PHOTO UPLOAD ── */
    .photo-upload-area {
        border: 2px dashed var(--border);
        border-radius: 10px;
        padding: 36px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
        min-height: 180px;
        background: var(--surface2);
    }

    .photo-upload-area:hover,
    .photo-upload-area.drag-over {
        border-color: var(--accent);
        background: rgba(0,212,255,.04);
    }

    .photo-upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .upload-text {
        text-align: center;
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
    }

    .upload-text span {
        display: block;
        font-size: 11px;
        color: var(--muted);
        opacity: .7;
    }

    .btn-pilih-foto {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: var(--radius);
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        z-index: 1;
        pointer-events: none;
    }

    /* Preview */
    .photo-preview-wrap {
        display: none;
        position: relative;
        width: 100%;
    }

    .photo-preview-wrap img {
        width: 100%;
        max-height: 260px;
        object-fit: contain;
        border-radius: 8px;
    }

    .remove-photo {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(0,0,0,.7);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        line-height: 1;
    }

    .remove-photo:hover { background: var(--danger); }

    /* ── FIELDS ── */
    .field-group {
        display: grid;
        gap: 18px;
    }

    .grid-2 { grid-template-columns: 1fr 1fr; }
    .grid-3 { grid-template-columns: 2fr 1fr; }

    .field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .field label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 4px;
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

    .input-field.is-invalid { border-color: var(--danger); }

    select.input-field {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238892a4' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }

    textarea.input-field {
        resize: vertical;
        min-height: 90px;
        line-height: 1.6;
    }

    .field-error {
        font-size: 11px;
        color: var(--danger);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── FORM FOOTER ── */
    .form-footer {
        padding: 18px 28px;
        border-top: 1px solid var(--border);
        background: var(--surface2);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Existing photo */
    .existing-photo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 12px;
        font-size: 12px;
        color: var(--muted);
    }

    .existing-photo img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
    }
</style>
@endpush

@section('content')

<div class="back-bar">
    <a href="{{ route('dashboard') }}" class="back-btn">← Kembali</a>
    <span class="back-bar-title">{{ isset($barang) ? 'Edit Barang' : 'Tambah Barang Baru' }}</span>
</div>

<form
    method="POST"
    action="{{ isset($barang) ? route('barang.update', $barang->id) : route('barang.store') }}"
    enctype="multipart/form-data"
    id="formBarang"
>
    @csrf
    @if(isset($barang)) @method('PUT') @endif

    <div class="form-card">

        {{-- ── FOTO ── --}}
        <div class="form-section">
            <div class="section-title">Foto Barang</div>

            {{--
                Foto di DB disimpan sebagai 'barang/namafile.jpg'
                sehingga asset('storage/barang/namafile.jpg') langsung benar
                karena storage link mengarah ke storage/app/public/
            --}}
            @if(isset($barang) && $barang->foto)
                <div class="existing-photo" id="existingPhoto">
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto saat ini">
                    <span>Foto saat ini — upload baru untuk mengganti</span>
                </div>
            @endif

            <div class="photo-upload-area" id="uploadArea">
                <input
                    type="file"
                    name="foto"
                    id="inputFoto"
                    accept="image/jpg,image/jpeg,image/png,image/webp"
                >
                <div id="uploadPlaceholder">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:10px">
                        <div class="upload-icon">🖼️</div>
                        <div class="upload-text">
                            Klik untuk memilih foto, atau seret file ke sini
                            <span>Format: JPG, PNG, WebP — Maks. 2 MB</span>
                        </div>
                        <div class="btn-pilih-foto">📂 Pilih Foto</div>
                    </div>
                </div>
                <div class="photo-preview-wrap" id="previewWrap">
                    <img id="previewImg" src="" alt="Preview">
                    <button type="button" class="remove-photo" id="removePhoto" onclick="hapusFoto(event)">✕</button>
                </div>
            </div>

            @error('foto')
                <div class="field-error" style="margin-top:8px">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- ── INFO UTAMA ── --}}
        <div class="form-section">
            <div class="section-title">Informasi Barang</div>
            <div class="field-group" style="gap:16px">

                <div class="field">
                    <label>Nama barang <span class="req">*</span></label>
                    <input
                        type="text"
                        name="nama_barang"
                        class="input-field @error('nama_barang') is-invalid @enderror"
                        value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
                        placeholder="Ayam nugget crispy"
                    >
                    @error('nama_barang')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group grid-2">
                    <div class="field">
                        <label>Kategori <span class="req">*</span></label>
                        <select name="kategori_id" class="input-field @error('kategori_id') is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kategori_id', $barang->kategori_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Satuan <span class="req">*</span></label>
                        <select name="satuan" class="input-field @error('satuan') is-invalid @enderror">
                        @php
                            $satuans = [
                                'pcs',
                                'kg',
                                'gram',
                                'liter',
                                'ml',
                                'meter',
                                'cm',
                                'box',
                                'pack',
                                'dus'
                            ];
                        @endphp

                        <option value="">-- Pilih Satuan --</option>

                        @foreach ($satuans as $satuan)
                            <option value="{{ $satuan }}"
                                {{ old('satuan', $barang->satuan ?? '') == $satuan ? 'selected' : '' }}>
                                {{ strtoupper($satuan) }}
                            </option>
                        @endforeach
                    </select>

            @error('satuan')
                <div class="field-error">⚠ {{ $message }}</div>
            @enderror
                </div>
                </div>

                <div class="field-group grid-2">
                    <div class="field">
                        <label>Jumlah stok <span class="req">*</span></label>
                        <input
                            type="number"
                            name="stok"
                            class="input-field @error('stok') is-invalid @enderror"
                            value="{{ old('stok', $barang->stok ?? 0) }}"
                            min="0"
                            placeholder="120"
                        >
                        @error('stok')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Stok minimum</label>
                        <input
                            type="number"
                            name="stok_minimum"
                            class="input-field @error('stok_minimum') is-invalid @enderror"
                            value="{{ old('stok_minimum', $barang->stok_minimum ?? 0) }}"
                            min="0"
                            placeholder="20"
                        >
                        @error('stok_minimum')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field-group grid-2">
                    <div class="field">
                        <label>Harga jual (Rp) <span class="req">*</span></label>
                        <input
                            type="number"
                            name="harga_jual"
                            class="input-field @error('harga_jual') is-invalid @enderror"
                            value="{{ old('harga_jual', $barang->harga_jual ?? '') }}"
                            min="0"
                            placeholder="35000"
                        >
                        @error('harga_jual')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Harga beli (Rp)</label>
                        <input
                            type="number"
                            name="harga_beli"
                            class="input-field @error('harga_beli') is-invalid @enderror"
                            value="{{ old('harga_beli', $barang->harga_beli ?? '') }}"
                            min="0"
                            placeholder="28000"
                        >
                        @error('harga_beli')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field-group grid-2">
                    <div class="field">
                        <label>Berat / ukuran</label>
                        <input
                            type="text"
                            name="berat_ukuran"
                            class="input-field @error('berat_ukuran') is-invalid @enderror"
                            value="{{ old('berat_ukuran', $barang->berat_ukuran ?? '') }}"
                            placeholder="500 gram"
                        >
                        @error('berat_ukuran')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>Lokasi simpan</label>
                        <input
                            type="text"
                            name="lokasi_simpan"
                            class="input-field @error('lokasi_simpan') is-invalid @enderror"
                            value="{{ old('lokasi_simpan', $barang->lokasi_simpan ?? '') }}"
                            placeholder="Rak A-3"
                        >
                        @error('lokasi_simpan')
                            <div class="field-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label>Deskripsi</label>
                    <textarea
                        name="deskripsi"
                        class="input-field @error('deskripsi') is-invalid @enderror"
                        placeholder="Nugget ayam dengan lapisan tepung crispy..."
                    >{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <div class="field-error">⚠ {{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── FOOTER ── --}}
        <div class="form-footer">
            <a href="{{ route('dashboard') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($barang) ? '💾 Simpan Perubahan' : '✚ Simpan Barang' }}
            </button>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
    const inputFoto   = document.getElementById('inputFoto');
    const uploadArea  = document.getElementById('uploadArea');
    const placeholder = document.getElementById('uploadPlaceholder');
    const previewWrap = document.getElementById('previewWrap');
    const previewImg  = document.getElementById('previewImg');

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        tampilkanPreview(file);
    });

    // Drag & drop
    uploadArea.addEventListener('dragover', e => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            inputFoto.files = dt.files;
            tampilkanPreview(file);
        }
    });

    function tampilkanPreview(file) {
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            placeholder.style.display = 'none';
            previewWrap.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function hapusFoto(e) {
        e.stopPropagation();
        inputFoto.value = '';
        previewImg.src  = '';
        previewWrap.style.display = 'none';
        placeholder.style.display = 'block';
    }
</script>
@endpush