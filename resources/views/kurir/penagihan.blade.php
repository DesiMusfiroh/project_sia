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

        <h3 class="text-center"> <b> Penagihan </b></h3> <hr>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <br>
        <div class="row">
        @foreach ($penagihan as $item) 
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
                           
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <input type="hidden" name="status_pengiriman" value="dalam pengiriman">
                                <button type="button" style="background-color:#c4eb2a; " class="btn btn-sm" data-toggle="modal" data-target="#exampleModalCenter"
                                    id="detail"  
                                    data-id_update = "{{ $item->pesanan->id }}"
                                    data-pelanggan_id = "{{ $item->pesanan->pelanggan_id }}"
                                    data-pelanggan_nama = "{{ $item->pesanan->pelanggan->nama }}"
                                    data-pelanggan_no_hp = "{{ $item->pesanan->pelanggan->no_hp }}"
                                    data-tanggal_pesan = "{{ $item->pesanan->tanggal_pesan }}"
                                    data-total_harga = "{{ number_format($item->pesanan->total_harga) }}"
                                    data-jenis = "{{ $item->pesanan->jenis }}"
                                    data-status = "{{ $item->pesanan->status }}"
                                    data-cash = "{{ number_format($item->pesanan->cash) }}"
                                    data-change = "{{ number_format($item->pesanan->change) }}"
                                    data-piutang = "{{ $item->pesanan->piutang }}" >
                                    <i class="fa fa-truck"></i> <b> Penagihan  </b>   
                                </button>       
                           
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
                                    <td> <span id="id"></span></td>
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
        var cash            = $(this).data('cash');
        var change          = $(this).data('change');
        var piutang         = $(this).data('piutang');
        var piutang_awal         = $(this).data('piutang');
        var tanggal_pesan   = $(this).data('tanggal_pesan');
        var pelanggan_nama  = $(this).data('pelanggan_nama');
        var pelanggan_no_hp = $(this).data('pelanggan_no_hp');
        var pelanggan_id    = $(this).data('pelanggan_id');
        var jenis           = $(this).data('jenis');
        var status          = $(this).data('status');
        var total_harga     = $(this).data('total_harga');
      
        $('#id_update').val(id_update); 
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