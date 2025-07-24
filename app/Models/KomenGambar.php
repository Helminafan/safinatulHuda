<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomenGambar extends Model
{
    use HasFactory;
     protected $table = 'komengambar';
      protected $fillable = ['komen_id', 'foto_komentar'];
      public function komentar()
    {
        return $this->belongsTo('App\Models\KomentProduk', 'komen_id');
    }
}
