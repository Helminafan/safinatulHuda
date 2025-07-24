<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'judul_produk',
        'jenis_produk',
        'gambar_produk',
        'deskripsi_produk',
        'berat',
        'status_produk',
    ];  

    public function gambarProduk()
    {
        return $this->hasMany(GambarProduct::class, 'produk_id');
    }
    public function ulasan()
    {
        return $this->hasMany(KomentProduk::class, 'produk_id');
    }
}
