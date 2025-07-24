<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentProduk extends Model
{
    use HasFactory;
    protected $table = 'comentproduk';
    protected $fillable = [
        'produk_id',
        'nama_pengguna',
        'komentar',
        'email_pengguna',
        'status',
        'rating',
        'is_verified',
        'tanggal_komentar',
    ];
    protected $casts = [
        'tanggal_komentar' => 'datetime',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function gambarproduk()
    {
        return $this->hasMany(KomenGambar::class, 'komen_id');
    }
}
