<?php 
    use App\Pesanan;
    use App\Produk;
    use App\Pelanggan;
    use App\Pengiriman;
    use App\Detail_pesanan;

?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_owner')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        @if ($message = Session::get('success'))               
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
            </div>
        @endif 

    </div>
    <br>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                <span> <i class="fa fa-folder-open"></i> Data Transaksi</span>
            </div>
            <div class="card-body">
            <div class="container">         
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="alert alert-success alert-sm" role="alert">
                                {{$show_pesanan->status}}
                            </div> 
                        </div>

                        <div class="col-md-8 ml-auto">
                            <table>                              
                                <tr>
                                    <td>No Pesanan </td>
                                    <td> : </td>
                                    <td>{{ $show_pesanan->id }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pelanggan </td>
                                    <td> : </td>
                                    <td> {{ $show_pesanan->pelanggan->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesan </td>
                                    <td> : </td>
                                    <td>{{$show_pesanan->tanggal_pesan}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Pesanan </td>
                                    <td> : </td>
                                    <td> {{$show_pesanan->jenis}} </td>
                                </tr>                                
                            </table>
                        </div>
                    </div>
                           
                    <div class="form-group mt-2"> <!-- Baris Tabel Produk yang  dipesan -->
                        <p> <b> Data Produk yang dipesan </b></p>
                       
                        <table class="table table-bordered table-sm">
                            <thead class="text-center thead-dark">
                            <?php $i=0; ?>                                                                         
                                <tr>
                                <th scope="col" style="width:30px; color:#c4eb2a;">No</th>
                                <th scope="col" style="width:200px; color:#c4eb2a; ">Produk</th>
                                <th scope="col" style="width:50px; color:#c4eb2a;">Jlh</th>
                                <th scope="col" style="width:150px; color:#c4eb2a;">Harga</th>
                                <th scope="col" style="width:150px; color:#c4eb2a;">Sub Harga</th>                               
                                </tr>
                            </thead>
                          
                                
                            <?php $detail = App\Detail_pesanan::where('pesanan_id', $show_pesanan->id )->get(); ?>
                            @foreach  ($detail as $det)                   
                            <tbody>
                                <tr>
                                <th scope="row" class="text-center"><?php $i++;  echo $i; ?></th>
                                <td>{{ $det->produk->nama }}</td>
                                <td class="text-center"> {{ $det->jumlah }}</td>
                                <td class="text-right"> Rp. {{ number_format($det->harga) }}</td>
                                <td class="text-right"> Rp. {{ number_format($det->sub_harga) }}</td>                            
                                
                                </tr>  
                            </tbody> 
                            @endforeach
                            
                            <tbody class="text-center">                      
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <td colspan="3">Total Harga</td>
                                    <td class="text-right"> Rp. {{number_format($show_pesanan->total_harga)}} </td>
                                    
                                </tr>                          
                            </tbody>
                        </table>
                        
                    </div>

                    <div class="form-group">
                        <p class="mb-1"><b> Pembayaran </b></p>
                            <table>                              
                                <tr>
                                    <td style="width:100px"> Cash </td>
                                    <td> : </td>
                                    <td> Rp. {{number_format($show_pesanan->cash)}} </td>
                                </tr>
                                <tr>
                                    <td> Change </td>
                                    <td> : </td>
                                    <td> Rp. {{number_format($show_pesanan->change)}}</td>
                                </tr>
                                <tr>
                                    <td> Piutang </td>
                                    <td> : </td>
                                    <td> Rp. {{number_format($show_pesanan->piutang)}} </td>
                                </tr>                               
                            </table>
                    </div>

                </div>   
             </div>
        </div>
       
    </div>
</div>

@endsection
    </body>
</html>


