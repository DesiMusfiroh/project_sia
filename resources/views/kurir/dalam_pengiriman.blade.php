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
@extends('layouts.layout_kurir')

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

        <h3 class="text-center"> <b> Pesanan dalam pengiriman </b></h3> <hr>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
        <div class="row">
        @foreach ($dalam_pengiriman as $item) 
            <div class="col-sm-4 mb-4">
                <div class="card ">
                    <div class="card-header bg-dark text-center " style="font-size:15px; color:#c4eb2a; font-family:segoe ui black; ">
                        Nomor pesanan : {{ $item->pesanan_id}}
                        
                    </div>
                    <div class="card-body pb-3 "  >
                        <div class="" style="font-size:13px;" >
                            
                            <table  style="font-size:13px;">
                                <tr><td>Waktu Kirim</td> <td> : </td> <td> {{ $item->waktu_kirim}} </td></tr>
                            </table> <hr class="mb-1 mt-1">
                            <p class="mb-0"><b>Pelanggan </b></p>
                            <table  style="font-size:13px;">
                                <tr><td>Nama</td> <td> : </td> <td> {{ $item->pesanan->pelanggan->nama}} </td></tr>
                                <tr><td>Alamat</td> <td> : </td> <td> {{ $item->pesanan->pelanggan->alamat}} </td></tr>
                                <tr><td>No HP</td> <td> : </td> <td> {{ $item->pesanan->pelanggan->no_hp}} </td></tr>                                
                                <tr><td>Email</td> <td> : </td> <td> {{ $item->pesanan->pelanggan->email}} </td></tr>                                
                            </table>  <hr class="mb-1 mt-1">
                            <p class="mb-0"> <b> Data Produk yang dipesan </b></p>
                            
                            <?php 
                                $id_pesan = $item->pesanan_id;
                                $detail = App\Detail_pesanan::where('pesanan_id', $id_pesan )->get(); 
                            ?>                             
                            <table style="font-size:13px;">
                                @foreach ($detail as $det)
                                <tr><td> {{$det->produk->kode}} - </td> <td style="width:140px;"> {{$det->produk->nama}} </td> <td style="width:30px;" class="text-right"> {{$det->jumlah}}  </td></tr>
                                @endforeach
                            </table>  <hr class="mb-1 mt-1">
                            
                            <p class="mb-0"><b>Status :  </b> {{$item->pesanan->status}}</p>
                                                      
                        </div>
                        <hr class="mb-2 mt-1">
                        <div class="text-right">
                            <form action="/kurir/pengiriman/update_sampai" method="post">                         
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <input type="hidden" name="status_pengiriman" value="diterima pelanggan">
                                <button type="submit" style="background-color:#c4eb2a; " class="btn btn-sm text-center " >  
                                    <i class="fa fa-home"></i> <b> Pesanan diterima pelanggan  </b>   
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>


@endsection

</body>
</html>