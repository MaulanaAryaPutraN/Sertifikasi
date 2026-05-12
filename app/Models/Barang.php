<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Kategori;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'stok',
        'satuan',
        'harga_jual',
        'harga_beli',
        'stok_minimum',
        'berat_ukuran',
        'lokasi_simpan',
        'deskripsi',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
