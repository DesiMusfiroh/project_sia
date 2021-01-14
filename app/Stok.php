<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produk;

class Stok extends Model
{
    protected $table ='stok';
    protected $fillable = ['produk_nama','jumlah'];

   
    public function produk(){
    	return $this->hasOne(Produk::class,'produk_nama');
    }
}
