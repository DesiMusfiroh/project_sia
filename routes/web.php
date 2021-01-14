<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('auth.login');
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
    if (Auth::user()->role == '1'){
        return view('home_owner');
    } else if (Auth::user()->role == '2'){
        return view('home_gudang');
    } else if (Auth::user()->role == '3'){
        return view('home_kasir');
    } else if (Auth::user()->role == '4'){
        return view('home_kurir');
    }
});

Route::get('/owner/produk', 'ProdukController@index_owner');
Route::get('/owner/produk_terjual', 'ProdukController@produk_terjual');
Route::get('/owner/data_transaksi', 'PesananController@data_transaksi');
Route::get('/owner/pendapatan', 'PendapatanController@index');
Route::get('/owner/transaksi/{id}', 'PesananController@owner_show_id')->name('owner.transaksi');

Route::get('/gudang/produk', 'ProdukController@index');
Route::post('/gudang/produk/store','ProdukController@store');
Route::patch('/gudang/produk/update','ProdukController@update');
Route::post('/gudang/produk/delete','ProdukController@delete');
Route::get('/gudang/produk/stok','ProdukController@stok');

Route::get('/kasir/produk/stok','ProdukController@cek_stok');
Route::get('/kasir/produk/cari','ProdukController@kasir_cari');

Route::get('/kasir/transaksi','PesananController@index');
Route::get('orders/pdf/{invoice}', 'PesananController@pdf')->name('customer.order_pdf');
Route::get('kasir/transaksi/{id}', 'PesananController@show_id')->name('kasir.transaksi');

Route::get('/kasir/pesanan','PesananController@create');
Route::post('/kasir/pesanan/store','PesananController@store');
Route::get('/kasir/pesanan/delivery','PesananController@create_delivery');
Route::post('/kasir/pesanan/delivery/store','PesananController@store_delivery');

Route::get('/kasir/pelanggan', 'PelangganController@index');
Route::post('/kasir/pelanggan/store', 'PelangganController@store');
Route::patch('/kasir/pelanggan/update','PelangganController@update');
Route::post('/kasir/pelanggan/delete','PelangganController@delete');

Route::post('/kasir/detail_pesanan/store','PesananController@store_detail');
Route::patch('/kasir/detail_pesanan/update','PesananController@update_detail');
Route::get('/kasir/detail_pesanan/delete/{id}', 'PesananController@delete_detail');

Route::get('/kasir/piutang', 'PesananController@piutang');
Route::patch('/kasir/piutang/update', 'PesananController@piutang_update');

Route::get('/kurir/perlu_dikirim', 'PengirimanController@perlu_dikirim');
Route::patch('/kurir/pengiriman/update_kirim','PengirimanController@update_kirim');
Route::get('/kurir/dalam_pengiriman', 'PengirimanController@dalam_pengiriman');
Route::patch('/kurir/pengiriman/update_sampai','PengirimanController@update_sampai');
Route::get('/kurir/penagihan', 'PengirimanController@penagihan');
Route::get('/kurir/data_pesanan', 'PengirimanController@data_pesanan');
Route::get('kurir/transaksi/{id}', 'PesananController@kurir_show_id')->name('kurir.transaksi');















//Route::get('/gudang/stok', 'StokController@index');
//Route::post('/gudang/stok/store','StokController@store');
//Route::get('/kasir/stok', 'StokController@cek_stok');

