<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produk;
use App\Pesanan;

class Detail_pesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $fillable = ['pesanan_id','produk_id','jumlah','harga','sub_harga'];

    public function produk() {
        return $this->belongsTo(Produk::class);
    } 
    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    } 
}
