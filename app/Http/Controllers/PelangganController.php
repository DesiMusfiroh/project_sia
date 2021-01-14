<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pelanggan;

class PelangganController extends Controller
{
  
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('kasir.pelanggan',['pelanggan' => $pelanggan]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'alamat' => 'required',         
            'no_hp' => 'required',
            'email' => 'required',
        ]);

        Pelanggan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,

        ]);
        
        return redirect()->back()
        ->with('success','Great! Pelangan baru berhasil di tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $pelanggan = Pelanggan::findOrFail($request->id);
        $pelanggan->update($request->all());
        return redirect()->back()->with('success','Great! Data Pelanggan berhasil di update');
    }

    public function destroy($id)
    {
        //
    }
    public function delete(Request $request)
    {
        $pelanggan = Pelanggan::findOrFail($request->id);
		$pelanggan->delete();
		return redirect()->back()->with('success','Great! Data Pelanggan berhasil di hapus');
    }
}
