<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barang = $query->paginate(10)->withQueryString();
        $kategori = Kategori::all();

        $totalBarang    = Barang::count();
        $totalKategori  = Kategori::count();
        $stokMenipis    = Barang::where('stok', '>', 0)->where('stok', '<', 20)->count();
        $stokHabis      = Barang::where('stok', 0)->count();

        return view('dashboard', compact(
            'barang',
            'kategori',
            'totalBarang',
            'totalKategori',
            'stokMenipis',
            'stokHabis'
        ));
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('barang.detail', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('barang.form', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategori,id',
            'stok'          => 'required|integer|min:0',
            'satuan'        => 'required|string|max:50',
            'harga_jual'    => 'required|numeric|min:0',
            'harga_beli'    => 'nullable|numeric|min:0',
            'stok_minimum'  => 'nullable|integer|min:0',
            'berat_ukuran'  => 'nullable|string|max:100',
            'lokasi_simpan' => 'nullable|string|max:100',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Simpan langsung ke public/barang/
            $file->move(public_path('barang'), $namaFile);

            // DB menyimpan path relatif: 'barang/namafile.jpg'
            // Nanti di blade cukup: asset($barang->foto)
            $data['foto'] = 'barang/' . $namaFile;
        }

        Barang::create($data);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang   = Barang::findOrFail($id);
        $kategori = Kategori::all();
        return view('barang.form', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategori,id',
            'stok'          => 'required|integer|min:0',
            'satuan'        => 'required|string|max:50',
            'harga_jual'    => 'required|numeric|min:0',
            'harga_beli'    => 'nullable|numeric|min:0',
            'stok_minimum'  => 'nullable|integer|min:0',
            'berat_ukuran'  => 'nullable|string|max:100',
            'lokasi_simpan' => 'nullable|string|max:100',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari public/barang/ jika ada
            if ($barang->foto && file_exists(public_path($barang->foto))) {
                unlink(public_path($barang->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Simpan langsung ke public/barang/
            $file->move(public_path('barang'), $namaFile);

            $data['foto'] = 'barang/' . $namaFile;
        }

        $barang->update($data);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus foto dari public/barang/ jika ada
        if ($barang->foto && file_exists(public_path($barang->foto))) {
            unlink(public_path($barang->foto));
        }

        $barang->delete();

        return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus.');
    }
}
