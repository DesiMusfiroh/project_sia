<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pesanan;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $fillable = ['pesanan_id','waktu_kirim','status_stok','status_pengiriman'];

    public function pesanan() {
        return $this->belongsTo(Pesanan::class);
    } 
    
}
