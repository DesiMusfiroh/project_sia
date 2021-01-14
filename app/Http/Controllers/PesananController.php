<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pesanan;
use App\Produk;
use App\Pelanggan;
use App\Pengiriman;
use App\Detail_pesanan;
use PDF;

class PesananController extends Controller
{

    public function index()
    {
        $pesanan = Pesanan::orderBy('created_at', 'DESC')->paginate(10);
        $detail_pesanan = Detail_pesanan::all();
        return view('kasir.transaksi',compact('pesanan','detail_pesanan'));
    }
    public function show_id($id)
    {
        $show_pesanan = Pesanan::where('id',$id)->first();
        return view('kasir.transaksi_show', ['show_pesanan' => $show_pesanan]);
    }
    public function owner_show_id($id)
    {
        $show_pesanan = Pesanan::where('id',$id)->first();
        return view('owner.transaksi_show', ['show_pesanan' => $show_pesanan]);
    }
    public function kurir_show_id($id)
    {
        $show_pesanan = Pesanan::where('id',$id)->first();
        return view('kurir.transaksi_show', ['show_pesanan' => $show_pesanan]);
    }
    public function data_transaksi()
    {
        $pesanan = Pesanan::orderBy('created_at', 'DESC')->paginate(10);
        $detail_pesanan = Detail_pesanan::all();
        return view('owner.data_transaksi',compact('pesanan','detail_pesanan'));
    }
    
    public function pdf($invoice)
    {
        //GET DATA ORDER BERDASRKAN INVOICE
        $order = Pesanan::where('id', $invoice)->first();
        //JIKA DIA ADALAH PEMILIKNYA, MAKA LOAD VIEW BERIKUT DAN PASSING DATA ORDERS
        $pdf = PDF::loadView('kasir.pesanan_pdf', compact('order'));
        //KEMUDIAN BUKA FILE PDFNYA DI BROWSER
        return $pdf->stream();
    }

    public function create()
    {
        $produk = Produk::orderBy('created_at', 'DESC')->get();
        $id_terakhir = Pesanan::max('id');
        $detail_pesanan = Detail_pesanan::where('pesanan_id', $id_terakhir+1)->get();
        $pelanggan = Pelanggan::orderBy('created_at', 'DESC')->get();
       
        return view('kasir.pesanan', compact('produk','detail_pesanan','pelanggan','id_terakhir'));
    }
    public function create_delivery()
    {
        $produk = Produk::orderBy('created_at', 'DESC')->get();
        $id_terakhir = Pesanan::max('id');
        $detail_pesanan = Detail_pesanan::where('pesanan_id', $id_terakhir+1)->get();
        $pelanggan = Pelanggan::orderBy('created_at', 'DESC')->get();
        return view('kasir.pesanan_delivery', compact('produk','detail_pesanan','pelanggan','id_terakhir'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'pelanggan_id'  => 'required',
            'total_harga'   => 'required',         
            'tanggal_pesan' => 'required',
            'cash'          => 'required',
            'change'        => 'required',
            'piutang'       => 'required',
            'jenis'         => 'required',
            'status'        => 'required',
            
        ]);

        Pesanan::create([
            'pelanggan_id'  => $request->pelanggan_id,
            'total_harga'   => $request->total_harga,
            'tanggal_pesan' => $request->tanggal_pesan,
            'cash'          => $request->cash,
            'change'        => $request->change,
            'piutang'       => $request->piutang,
            'jenis'         => $request->jenis,
            'status'        => $request->status,
        ]);
        
        return redirect()->back()
        ->with('success','Great! Pesanan baru berhasil di buat');
    }

    public function store_delivery(Request $request)
    {
        $this->validate($request,[
            'pelanggan_id'  => 'required',
            'total_harga'   => 'required',         
            'tanggal_pesan' => 'required',
            'cash'          => 'required',
            'change'        => 'required',
            'piutang'       => 'required',
            'jenis'         => 'required',
            'status'        => 'required',
        ]);

        Pesanan::create([
            'pelanggan_id'  => $request->pelanggan_id,
            'total_harga'   => $request->total_harga,
            'tanggal_pesan' => $request->tanggal_pesan,
            'cash'          => $request->cash,
            'change'        => $request->change,
            'piutang'       => $request->piutang,
            'jenis'         => $request->jenis,
            'status'        => $request->status,
        ]);
        
        $date = $request->date ;
        $time   = $request->time ;
        $waktu_kirim = ' '.$date.' / '. $time.'';
        Pengiriman::create([
            'pesanan_id'        => $request->pesanan_id,
            'waktu_kirim'       => $waktu_kirim,
            'status_pengiriman' => $request->status_pengiriman,
            'status_stok'       => $request->status_stok,
        ]);
        
        return redirect()->back()
        ->with('success','Great! Pesanan baru berhasil di buat');
    }

    public function store_detail(Request $request)
    {
        
        $this->validate($request,[
            'pesanan_id' => 'required',
            'produk_id' => 'required',         
            'jumlah' => 'required',
        ]);

        $harga =  Produk::where('id',$request->produk_id)->value('harga');
        $jumlah = $request->jumlah;
        $sub_harga = $harga * $jumlah ;
    
        Detail_pesanan::create([
            'pesanan_id' => $request->pesanan_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'harga' => $harga,
            'sub_harga' => $sub_harga,
        ]);
        
        $stok_awal = Produk::where('id',$request->produk_id)->value('stok');
        $stok_akhir = $stok_awal - $request->jumlah;
        $update_stok = [
            'stok' => $stok_akhir,
        ];
        Produk::whereId($request->produk_id)->update($update_stok);
        return redirect()->back();
    }

    public function update_detail(Request $request)
    {
        $jumlah_awal = Detail_pesanan::where('id',$request->id)->value('jumlah');
        $jumlah_akhir = $request->jumlah ;

        $harga =  Produk::where('id',$request->produk_id)->value('harga');
        $jumlah = $request->jumlah;
        $sub_harga = $harga * $jumlah ;

        $update_detail_pesanan = [
            'jumlah' => $request->jumlah,
            'sub_harga' => $sub_harga,
        ];
        Detail_pesanan::whereId($request->id)->update($update_detail_pesanan);

        $stok_awal_update = Produk::where('id',$request->produk_id)->value('stok');
        $stok_akhir_update = $stok_awal_update - ($jumlah_akhir - $jumlah_awal);

        $update_stok = [
            'stok' => $stok_akhir_update,
        ];
        Produk::whereId($request->produk_id)->update($update_stok);

        return redirect()->back();
    }
    public function delete_detail($id)
    {
        $jumlah_produk = Detail_pesanan::where('id',$id)->value('jumlah');
        $produk_id = Detail_pesanan::where('id',$id)->value('produk_id');
        $stok_awal = Produk::where('id',$produk_id)->value('stok');
        $stok_akhir = $stok_awal + $jumlah_produk;

        $update_stok = [
            'stok' => $stok_akhir,
        ];
        Produk::whereId($produk_id)->update($update_stok);
      
        Detail_pesanan::whereId($id)->delete();
        return redirect()->back();
    }

    public function piutang()
    {
        $piutang = Pesanan::where('status','belum lunas')->get();
        $detail_pesanan = Detail_pesanan::all();
        return view('kasir.piutang',compact('piutang','detail_pesanan'));
    }
    public function piutang_update(Request $request)
    {
        $piutang_awal = $request->piutang_awal;
        $piutang_bayar = floatval($request->piutang_update);
        $piutang_akhir = $piutang_awal - $piutang_bayar;
        $cash_awal = Pesanan::where('id',$request->id_update)->value('cash');
        $cash_akhir = $cash_awal + $piutang_bayar;
        $jenis = Pesanan::where('id',$request->id_update)->value('jenis');
        $status_pengiriman = Pengiriman::where('pesanan_id', $request->id_update)->value('status_pengiriman');
        if ($jenis == "antar") {
            if ($piutang_akhir == 0 && $status_pengiriman == "diterima pembeli") {
                $status = "pesanan selesai";
            } else if($piutang_akhir == 0) {
                $status = "lunas"; 
            } else {
                $status = "belum lunas"; 
            }
        } else {
            if ($piutang_akhir == 0) {
                $status = "pesanan selesai";
            } else {$status = "belum lunas";}
        }
    
        $update_piutang = [
            'piutang' => $piutang_akhir,
            'cash' => $cash_akhir,
            'status' => $status,
        ];
        Pesanan::whereId($request->id_update)->update($update_piutang);
        return redirect()->back()->with('success',"Great! Data Piutang berhasil di update ");
    }

    
}
