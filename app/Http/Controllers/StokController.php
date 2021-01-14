<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stok;
use App\Produk;


class StokController extends Controller
{

    public function index()
    {
        $stok = Stok::all();
        return view('gudang.stok',['stok' => $stok]);
    }
    public function cek_stok()
    {
        $stok = Stok::all();
        return view('kasir.cek_stok',['stok' => $stok]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'produk_nama' => 'required',
            'jumlah' => 'required',         
        ]);

        Stok::create([
            'produk_nama' => $request->produk_nama,
            'jumlah' => $request->jumlah,
        ]);
        
        return redirect('/gudang/stok')
        ->with('success','Great! Stok Produk baru berhasil di tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
