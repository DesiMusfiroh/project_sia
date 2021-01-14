<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pesanan;
use App\Produk;
use App\Pelanggan;
use App\Pengiriman;
use App\Detail_pesanan;
use DB;

class PengirimanController extends Controller
{
    public function perlu_dikirim()
    {
        $pesanan = Pesanan::all();
        $perlu_dikirim = Pengiriman::where('status_pengiriman','menunggu pengiriman')->get();
        return view('kurir.perlu_dikirim',compact('pesanan','perlu_dikirim'));
    }
    public function update_kirim(Request $request)
    { 
        $update_kirim = [
            'status_pengiriman' => $request->status_pengiriman,
        ];
        Pengiriman::whereId($request->id)->update($update_kirim);
        return redirect()->back()->with('success','Great! Data Pengiriman  berhasil di update');
    }
    public function dalam_pengiriman()
    {
        $pesanan = Pesanan::all();
        $dalam_pengiriman = Pengiriman::where('status_pengiriman','dalam pengiriman')->get();
        return view('kurir.dalam_pengiriman',compact('pesanan','dalam_pengiriman'));
    }
    public function update_sampai(Request $request)
    { 
        $update_sampai = [
            'status_pengiriman' => $request->status_pengiriman,
        ];
        Pengiriman::whereId($request->id)->update($update_sampai);
        return redirect()->back()->with('success','Great! Data Pengiriman  berhasil di update');
    }
    public function penagihan()
    {
        $penagihan = Pengiriman::join('pesanan', function ($join) {
                        $join->on('pengiriman.pesanan_id', '=', 'pesanan.id')
                            ->where('pesanan.status', '=', 'belum lunas');
                    })->where('status_pengiriman','=','diterima pelanggan')->get();
        return view('kurir.penagihan',compact('penagihan'));
    }
    public function data_pesanan()
    {
        $pengiriman = Pengiriman::orderBy('created_at', 'DESC')->paginate(10);
        $detail_pesanan = Detail_pesanan::all();
        return view('kurir.data_pesanan',compact('pengiriman','detail_pesanan'));
    }
}
