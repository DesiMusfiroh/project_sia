<?php use App\Produk; ?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_owner')

@section('content')

<div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">

                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Daftar Produk</span>
                </div>

                <div class="card-body">
           
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col" style="width:50px">No</th>
                                <th scope="col" style="width:150px">Kode Produk</th>
                                <th scope="col" style="width:300px">Nama Produk</th>
                                <th scope="col" style="width:400px">Deskripsi Produk</th>
                                <th scope="col" style="width:150px">Harga</th>
                                <th scope="col" style="width:150px">Jumlah Stok</th>
                                
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>                                                 
                            @foreach ($produk as $pro) 
                            <tr>
                                <td scope="row"  class="text-center"><?php  $i++;  echo $i; ?></td>
                                <td class="text-center">{{ $pro->kode }}</td>
                                <td>{{ $pro->nama }}</td>
                                <td>{{ $pro->deskripsi }}</td>
                                <td class="text-right">Rp. {{ number_format($pro->harga) }}</td>
                                <td class="text-center">{{ $pro->stok }}</td>
                                                  
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>

                    <div class="row ">
                        <div class="col-12 text-center ">
                            {{ $produk->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

</body>
</html>