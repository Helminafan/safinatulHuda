<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarProduct extends Model
{
    use HasFactory;
    protected $table = 'gambarproduk'; // Specify the table name if it differs from the model name
    protected $fillable = ['produk_id', 'gambar']; // Fillable attributes for mass assignment
    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }
}
