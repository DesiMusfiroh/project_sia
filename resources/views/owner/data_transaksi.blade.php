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

    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                <span> <i class="fa fa-folder-open"></i> Data Transaksi</span>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-light text-center">
                        <tr>
                            <th scope="col" style="width:50px">No</th>
                            <th scope="col" >No Pesanan</th>
                            <th scope="col" >Tanggal Pesan</th>
                            <th scope="col" >Pelanggan</th>
                            <th scope="col" >Total Harga</th>
                            <th scope="col" >Jenis</th>
                            <th scope="col" >Status</th>                           
                            <th scope="col" ></th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>                                                 
                        @foreach ($pesanan as $pesan) 
                        <tr>
                            <td scope="row" class="text-center"><?php  $i++;  echo $i; ?></td>
                            <td scope="row" class="text-center"> {{ $pesan->id }}</td>
                            <td scope="row" class="text-center">{{ $pesan->tanggal_pesan }}</td>
                            <td>{{ $pesan->pelanggan->nama }}</td>
                            <td class="text-right"> Rp. {{ number_format($pesan->total_harga) }}</td>                                                                        
                            <td class="text-right">{{ $pesan->jenis }}</td>                                                                        
                            <td class="text-center"> {{ $pesan->status}} </td>    
                            <td class="text-center">
                                <a href="{{ route('owner.transaksi', $pesan->id) }}" style="background-color:#c4eb2a; " class="btn btn-sm" > <span class="fa fa-search"></span></a>
                                <!-- <button type="button" style="background-color:#c4eb2a; " class="btn btn-sm" data-toggle="modal" data-target=".detail_modal"
                                    id="detail"   
                                    data-id = "{{ $pesan->id }}"
                                    data-pelanggan_id = "{{ $pesan->pelanggan_id }}"
                                    data-pelanggan_nama = "{{ $pesan->pelanggan->nama }}"
                                    data-tanggal_pesan = "{{ $pesan->tanggal_pesan }}"
                                    data-total_harga = "{{ number_format($pesan->total_harga) }}"
                                    data-jenis = "{{ $pesan->jenis }}"
                                    data-status = "{{ $pesan->status }}"
                                    data-cash = "{{ number_format($pesan->cash) }}"
                                    data-change = "{{ number_format($pesan->change) }}"
                                    data-piutang = "{{ number_format($pesan->piutang) }}"
                                    >  
                                    <i class="fa fa-search fa-sm"></i>             
                                </button>                                -->
                            </td>                           
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
                    <div class="row ">
                        <div class="col-12 text-center ">
                            {{ $pesanan->links() }}
                        </div>
                    </div>
             </div>
        </div>
       
    </div>
</div>

            
<!-- Detail  modal -->
<div class="modal fade detail_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Detail Transaksi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">     
                <div class="container">         
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="alert alert-success alert-sm" role="alert">
                                <span id="status"></span>
                            </div> 
                        </div>

                        <div class="col-md-8 ml-auto">
                            <table>                              
                                <tr>
                                    <td>No Pesanan </td>
                                    <td> : </td>
                                    <td> <span id="id"></span></td>
                                </tr>
                                <tr>
                                    <td>Nama Pelanggan </td>
                                    <td> : </td>
                                    <td> <span id="pelanggan_nama"></span></td>
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

                            <?php $detail = App\Detail_pesanan::where('pesanan_id', 1 )->get(); ?>
                            @foreach  ($detail as $det)                   
                            <tbody>
                                <tr>
                                <th scope="row" class="text-center"><?php $i++;  echo $i; ?></th>
                                <td>{{ $det->produk->nama }}</td>
                                <td class="text-center"> {{ $det->jumlah }}</td>
                                <td class="text-right"> Rp. {{ $det->harga }}</td>
                                <td class="text-right"> Rp. {{ $det->sub_harga }}</td>                            
                                
                                </tr>  
                            </tbody> 
                            @endforeach
                            
                            <tbody class="text-center">                      
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <td colspan="3">Total Harga</td>
                                    <td class="text-right"> Rp. <span id="total_harga"></span></td>
                                    
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
                                    <td> Rp. <span id="cash"></span></td>
                                </tr>
                                <tr>
                                    <td> Change </td>
                                    <td> : </td>
                                    <td> Rp. <span id="change"></span></td>
                                </tr>
                                <tr>
                                    <td> Piutang </td>
                                    <td> : </td>
                                    <td> Rp. <span id="piutang"> </span></td>
                                </tr>                               
                            </table>
                    </div>

                </div>                               

            </div>

            <div class="modal-footer">   
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                              
            </div>
            </form>

        </div>
    </div>
    </div>
    
<!-- Penutup Detail  modal -->


<script>
$(document).ready(function(){
    $(document).on('click','#detail', function(){
        var id              = $(this).data('id');
        var cash            = $(this).data('cash');
        var change          = $(this).data('change');
        var piutang         = $(this).data('piutang');
        var tanggal_pesan   = $(this).data('tanggal_pesan');
        var pelanggan_id    = $(this).data('pelanggan_id');
        var pelanggan_nama  = $(this).data('pelanggan_nama');
        var jenis           = $(this).data('jenis');
        var status          = $(this).data('status');
        var total_harga     = $(this).data('total_harga');
      
        $('#id').text(id); 
        $('#cash').text(cash);      
        $('#change').text(change);      
        $('#piutang').text(piutang);      
        $('#tanggal_pesan').text(tanggal_pesan);      
        $('#pelanggan_nama').text(pelanggan_nama);      
        $('#jenis').text(jenis);      
        $('#status').text(status);      
        $('#total_harga').text(total_harga);      
               
    });

});
</script>

@endsection
    </body>
</html>


