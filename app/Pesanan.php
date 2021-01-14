<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Detail_pesanan;
use App\Pengiriman;
use App\Pelanggan;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $fillable = ['pelanggan_id','total_harga','tanggal_pesan','cash','change','piutang','jenis','status'];

    public function detail_pesanan()
    {
    	return $this->hasOne(Detail_pesanan::class,'pesanan_id');
    }
    public function pengiriman()
    {
    	return $this->hasOne(Pengiriman::class,'pesanan_id');
    }
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class);
    }
    
}
