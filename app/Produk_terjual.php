<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produk;
use App\Detail_pesanan;

class Produk_terjual extends Model
{
    protected $table = 'produk_terjual';
    public function produk() {
        return $this->belongsTo(Produk::class);
    } 
}
