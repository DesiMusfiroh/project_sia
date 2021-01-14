<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pesanan;

class Pelanggan extends Model
{
    protected $table ='pelanggan';
    protected $fillable = ['nama','alamat','no_hp','email'];
    public function pesanan()
    {
    	return $this->hasOne(Pesanan::class,'pelanggan_id');
    }
}
