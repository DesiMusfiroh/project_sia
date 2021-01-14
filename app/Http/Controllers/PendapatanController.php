<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pesanan;
use App\Produk;
use App\Pelanggan;
use App\Pengiriman;
use App\Detail_pesanan;
use App\Pendapatan;

class PendapatanController extends Controller
{

    public function index()
    {
        $pendapatan = Pendapatan::all();
        $array[] = ['Tanggal','Penjualan','Piutang Pelanggan', 'Pendapatan'];
        foreach($pendapatan as $key =>$value) {
            $array[++$key] = [$value->tanggal_pesan, 
            floatval($value->penjualan), 
            floatval($value->piutang_pelanggan),
            floatval($value->pendapatan)];
        }
        //dd(json_encode($array));
        return view('owner.pendapatan', compact('pendapatan'))->with('tabel',json_encode($array));
    }

}
