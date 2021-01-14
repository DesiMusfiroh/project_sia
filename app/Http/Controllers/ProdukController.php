<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Produk_terjual;

class ProdukController extends Controller
{
    public function index()
    {
        //$produk = Produk::all();
        //return view('gudang.produk',['produk' => $produk]);
        $produk = Produk::paginate(6);
        return view('gudang.produk',compact('produk'));

    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required',         
            'deskripsi' => 'required',
        ]);

        Produk::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);
        
        return redirect('/gudang/produk')
        ->with('success','Great! Produk baru berhasil di tambahkan');
    }
    public function update(Request $request)
    {
        $produk = Produk::findOrFail($request->id);
        $produk->update($request->all());
        return redirect()->back()->with('success','Great! Data Produk berhasil di update');
    }
    public function delete(Request $request)
    {
        $produk = Produk::findOrFail($request->id);
		$produk->delete();
		return redirect()->back()->with('success','Great! Data Produk berhasil di hapus');
    }
    public function stok()
    {
        $stok = Produk::all();
        return view('gudang.stok',['stok' => $stok]);
    }
    public function cek_stok()
    {
        $produk = Produk::all();
        return view('kasir.cek_stok',['produk' => $produk]);
    }
    public function index_owner()
    {
        $produk = Produk::paginate(6);   
        return view('owner.produk',compact('produk'));
    }
    public function kasir_cari(Request $request)
    {
        $cari = $request->cari;
        $produk = Produk::where('nama','like',"%".$cari."%")->paginate();
        return view('kasir.cek_stok',['produk' => $produk]);
    }
    public function produk_terjual()
    {
        $produk_terjual = Produk_terjual::all();
        // $produk = [];
        // $jumlah = [];
        // foreach($produk_terjual as $pt){
        //     $produk[] = $pt->produk->nama;
        //     $jumlah[] = $pt->jumlah_terjual;
        // }
        //dd(json_encode($produk));
        //dd(json_encode($jumlah));
        // return view('owner.produk_terjual', compact('produk_terjual','jumlah','produk'));
        
        $array[] = ['Produk','Jumlah'];
        foreach($produk_terjual as $key =>$value) {
            $array[++$key] = [$value->produk->nama, floatval($value->jumlah_terjual)];
        }
        return view('owner.produk_terjual', compact('produk_terjual'))->with('produk',json_encode($array));
        
    }
}
 