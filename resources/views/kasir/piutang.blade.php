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
@extends('layouts.layout_kasir')

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

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                <span> <i class="fa fa-folder-open"></i> Data Piutang Pelanggan</span>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-light text-center">
                        <tr>
                            <th scope="col" style="width:50px">No</th>
                            <th scope="col" >Nama Pelanggan</th>
                            <th scope="col" >No Pesanan</th>
                            <th scope="col" >Tanggal Pesan</th>
                            <th scope="col" >Jenis Pesanan</th>
                            <th scope="col" >Jumlah Piutang</th>                                               
                            <th scope="col" ></th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>                                                 
                        @foreach ($piutang as $piu) 
                        <tr>
                            <td scope="row" class="text-center"><?php  $i++;  echo $i; ?></td>
                            <td scope="row" class="text-center"> {{ $piu->pelanggan->nama }}</td>
                            <td scope="row" class="text-center">{{ $piu->id }}</td>
                            <td scope="row" class="text-center">{{ $piu->tanggal_pesan}}</td>
                            <td class="text-center">{{ $piu->jenis }}</td>                                                                        
                            <td class="text-right">Rp. {{ number_format($piu->piutang) }}</td>                                                                         
                            <td class="text-center">
                                <button type="button" style="background-color:#c4eb2a; " class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter"
                                    id="detail"  
                                    data-id_update = "{{ $piu->id }}"
                                    data-pelanggan_id = "{{ $piu->pelanggan_id }}"
                                    data-pelanggan_nama = "{{ $piu->pelanggan->nama }}"
                                    data-pelanggan_no_hp = "{{ $piu->pelanggan->no_hp }}"
                                    data-tanggal_pesan = "{{ $piu->tanggal_pesan }}"
                                    data-total_harga = "{{ number_format($piu->total_harga) }}"
                                    data-jenis = "{{ $piu->jenis }}"
                                    data-status = "{{ $piu->status }}"
                                    data-cash = "{{ number_format($piu->cash) }}"
                                    data-change = "{{ number_format($piu->change) }}"
                                    data-piutang = "{{ $piu->piutang }}" >
                                    <i class="fa fa-money fa-sm"></i>
                                </button>                           
                            </td>                           
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
                  
             </div>
        </div>
       
    </div>
</div>

<!-- pembuka update modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Piutang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/kasir/piutang/update" method="post">
            @csrf
            @method('PATCH')  
            <div class="modal-body">
                <div class="container">         
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <table class="table-striped ">                                                        
                                <tr>
                                    <td>Nama Pelanggan </td>
                                    <td> : </td>
                                    <td> <span id="pelanggan_nama"></span></td>
                                </tr>
                                <tr>
                                    <td>No HP </td>
                                    <td> : </td>
                                    <td> <span id="pelanggan_no_hp"></span></td>
                                </tr>
                                <tr>
                                    <td>No Pesanan </td>
                                    <td > : </td>
                                    <td> <span id="id_pesan"></span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesan </td>
                                    <td> : </td>
                                    <td><span id="tanggal_pesan"> </span></td>
                                </tr>
                                <tr>
                                    <td>Jenis Pesanan </td>
                                    <td> : </td>
                                    <td> <span id="jenis"></span> </td>
                                </tr>   
                                <tr>
                                    <td>Total Harga</td>
                                    <td> : </td>
                                    <td> Rp. <span id="total_harga"></span> </td>
                                </tr>  
                                <tr>
                                    <td>Pembayaran</td>
                                    <td> : </td>
                                    <td> Rp. <span id="cash"></span> </td>
                                </tr>                                                             
                            </table>
                        </div>
                        <div class="col-md-5 justify-content-center">
                            <div class="form-group text-center">
                                <div class="alert alert-danger pt-2 pb-2" role="alert">
                                    <p class="mb-1"><b>Jumlah Piutang</b></p>
                                    <p class="mb-1"><b> Rp. <span id="piutang"></span> </b></p>
                                </div>
                                <p class="mb-2"> <b> Pelunasan </b></p>
                                <input type="hidden" id="id_update" name="id_update" value="" >
                                <input type="hidden" id="piutang_awal" name="piutang_awal" value="">
                               
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend" >
                                        <div class="input-group-text" > <b>Rp.</b></div>
                                    </div>
                                    <input type="text" id="piutang_update" name="piutang_update" class="form-control text-right">
                                </div>                                
                        </div>
                    </div>

                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
<!-- penutup update modal -->


<script>
$(document).ready(function(){
    $(document).on('click','#detail', function(){
        var id_update       = $(this).data('id_update');
        var id_pesan        = $(this).data('id_update');
        var cash            = $(this).data('cash');
        var change          = $(this).data('change');
        var piutang         = $(this).data('piutang');
        var piutang_awal    = $(this).data('piutang');
        var tanggal_pesan   = $(this).data('tanggal_pesan');
        var pelanggan_nama  = $(this).data('pelanggan_nama');
        var pelanggan_no_hp = $(this).data('pelanggan_no_hp');
        var pelanggan_id    = $(this).data('pelanggan_id');
        var jenis           = $(this).data('jenis');
        var status          = $(this).data('status');
        var total_harga     = $(this).data('total_harga');
      
        $('#id_update').val(id_update); 
        $('#id_pesan').text(id_pesan); 
        $('#cash').text(cash);      
        $('#change').text(change);      
        $('#piutang').text(piutang);      
        $('#piutang_awal').val(piutang_awal);      
        $('#tanggal_pesan').text(tanggal_pesan);      
        $('#pelanggan_nama').text(pelanggan_nama);      
        $('#pelanggan_no_hp').text(pelanggan_no_hp);      
        $('#pelanggan_id').text(pelanggan_id);      
        $('#jenis').text(jenis);      
        $('#status').text(status);      
        $('#total_harga').text(total_harga);                   
    });
});
</script>
@endsection
    </body>
</html>
