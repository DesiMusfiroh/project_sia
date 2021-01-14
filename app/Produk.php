<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Detail_pesanan;
use App\Produk_terjual;

class Produk extends Model
{
    protected $table ='produk';
    protected $fillable = ['kode','nama','harga','deskripsi','stok'];

    public function detail_pesanan()
    {
    	return $this->hasOne(Detail_pesanan::class,'produk_id');
    }
    public function produk_terjual()
    {
    	return $this->hasOne(Produk_terjual::class,'produk_id');
    }
}
