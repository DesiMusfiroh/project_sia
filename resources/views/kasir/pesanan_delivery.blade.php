<?php 
    use App\Produk; 
    use App\Pesanan; 
    use App\Pelanggan; 
    use App\Pengiriman; 
    use App\Detail_pesanan; 
?>
@extends('layouts.layout_kasir')
@section('content')
<html>
<head> </head>
<body>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8">
                <div class="text-center"> <h5><b>Buat Pesanan Baru</b></h5></div><hr>
            </div>
            <div class="col-md-4">
                <!-- Pembuka Nav Menu -->
                    <div class="container">       
                        <ul class="nav nav-tabs justify-content-center nav-fill stiky-top ">     
                            <li class="nav-item ">
                                <a class="nav-link  {{(request()->is('kasir/pesanan')) ? 'active' : ''}}" style="font-weight:bold; " href="/kasir/pesanan">Langsung</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link {{(request()->is('kasir/pesanan/delivery')) ? 'active' : ''}}" style="font-weight:bold;" href="/kasir/pesanan/delivery">Pesan Antar</a>
                            </li>
                        </ul>
                    </div>
                <!-- Penutup Nav Menu -->
            </div>
        </div>

       

        @if ($message = Session::get('success'))               
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }} <a href="{{ route('customer.order_pdf', $id_terakhir) }}" target="_blank" class="mr-5 ml-5" style="font-size:17px;"> <span class="fa fa-print"></span> Cetak Invoice </a></strong>
            </div>
        @endif

        <section class="content">

            <div class="row">                              
                <div class="col-md-3"> <!-- Form Tambah Produk yang dipesan -->

                    <div class="row">
                        <div class="col-md-7"> <label for=""> Pre Order : </label></div>
                        <div class="col-md-5 text-right">
                            <div class="btn-group btn-group-toggle " data-toggle="buttons">  
                                <label class="btn btn-primary btn-sm">
                                    <input type="radio" name="preorder" id="preorder" >  <i class="fa fa-check"></i>
                                </label>
                                <label class="btn btn-primary btn-sm">
                                    <input type="radio" name="preorder" id="ready" checked> <i class="fa fa-times"></i> 
                                </label>
                                
                            </div>
                        </div>
                    </div>
                   
                    <form action="/kasir/detail_pesanan/store" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="pesanan_id" id="pesanan_id" value="<?php echo $id_terakhir+1; ?>">
                        <div class="form-group">
                            <label for="">Produk</label>
                            <select name="produk_id" id="produk_id" class="form-control" required width="100%">
                                <option value="">Pilih</option>
                                @foreach ($produk as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->kode }} - {{ $pro->nama }} ( {{ $pro->stok }} )</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" value="1" min="1" max="" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-md">
                                <i class="fa fa-shopping-cart"></i> -  Ke Keranjang
                            </button>
                        </div>
                    </form>

                </div> 

                <div class="col-md-9"> <!-- Sisi Kanan Proses Pemesanan-->    

                    <form action="/kasir/pesanan/delivery/store" enctype="multipart/form-data" method="post">
                    @csrf

                    <div class="row">  <!-- Nomor Pesanan -->    
                        <div class="col-md-8">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text" > <b> No Pesanan </b></div>
                                </div>
                                <input type="text" name="pesanan_id" id="pesanan_id" value="<?php echo $id_terakhir+1; ?>"  class="form-control text-right" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"> Tanggal Pemesanan : <br>
                            <?php $tgl=date('l, d-M-Y'); echo $tgl;?> </p>
                            <input type="hidden" id="tanggal_pesan" name="tanggal_pesan" value="<?php echo date('d-m-Y'); ?>">
                        </div>
                    </div>
               
                    <div class="row mb-2"> <!-- Baris Pelanggan -->                 
                        <div class="col-md-6"> <!-- Pilih Pelanggan -->

                            <label for=""> <b> Pelanggan </b> </label>
                            <div class="row mb-2">
                                <div class="col-md-10">
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required width="100%">
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach ($pelanggan as $pel)
                                        <option value="{{ $pel->id }}" id_customer="{{ $pel->id }}" nama_customer="{{$pel->nama}}" no_hp_customer="{{$pel->no_hp}}" email_customer="{{$pel->email}}" alamat_customer="{{$pel->alamat}}"> {{ $pel->nama }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-right" style="font-size:20px; font-family:segoe ui black; font-weight:bold;">
                                        <a> <button type="button" class="btn" style="background-color:#c4eb2a;" data-toggle="modal" data-target=".create_modal" id="create">
                                            <i class="fa fa-plus"></i> </button> 
                                        </a> 
                                    </div>
                                </div>
                            </div> 
                                           
                        </div>
                        
                        <div class="col-md-6"> <!-- Tampilkan Pelanggan yang dipilih -->                        
                        <p style="margin-bottom:1px;" > Nama Pelanggan : <span id="nama_customer"></span> </p>
                            <p style="margin-bottom:1px;"> Nomor HP :  <span id="no_hp_customer"></span> </p>
                            <p style="margin-bottom:1px;"> Alamat :  <span id="alamat_customer"></span>  </p>
                        </div>
                    </div>
                    
                    <div class="row "> <!-- Baris Pengiriman -->  
                        <div class="col-md-3">
                            <label for=""> <b> Pengiriman </b> </label>
                        </div>
                        <div class="col-md-1 text-right"> <label for=""> Date: </label>  </div>
                        <div class="col-md-4">                           
                            <div class="form-group"> <!-- Date input -->  
                                                                    
                                <input class="form-control" id="date" name="date" placeholder="Tanggal Pesan" type="date"/>
                            </div>  
                        </div> 
                        <div class="col-md-1 text-right "> <label for="">  Time:</label>  </div>
                        <div class="col-md-3 ">
                            <div class="form-group"> <!-- time input --> 
                                                                     
                                <input class="form-control" id="time" name="time"  placeholder="Tanggal Pesan" type="time"/>
                            </div>
                        </div>
                              
                    </div>

                    <div class="form-group"> <!-- Baris Tabel Produk yang akan dipesan -->
                        <p> <b> Data Produk yang akan dipesan </b></p>
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark text-center">
                            <?php $i=0; ?>                                                 
                           
                                <tr>
                                <th scope="col" style="width:30px; color:#c4eb2a;">No</th>
                                <th scope="col" style="width:200px; color:#c4eb2a;">Produk</th>
                                <th scope="col" style="width:50px; color:#c4eb2a;">Jumlah</th>
                                <th scope="col" style="width:150px; color:#c4eb2a;">Harga</th>
                                <th scope="col" style="width:150px; color:#c4eb2a;">Sub Harga</th>
                                <th scope="col" style="width:80px"></th>
                                </tr>
                            </thead>
                            <?php $total_harga = 0 ?>
                            @foreach ($detail_pesanan as $dp) 
                            <tbody>
                                <tr>
                                <th scope="row" class="text-center"><?php $i++;  echo $i; ?></th>
                                <td>{{ $dp->produk->nama }}</td>
                                <td class="text-center">{{ $dp->jumlah}}</td>
                                <td class="text-right"> Rp. {{ number_format($dp->harga) }}</td>
                                <td class="text-right"> Rp. {{ number_format($dp->sub_harga) }}</td>
                               
                                <td class="text-center"> 
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".update_modal"
                                        id="update"                                   
                                        data-id="{{ $dp->id }}" 
                                        data-jumlah_update="{{ $dp->jumlah }}"
                                        data-nama_update="{{ $dp->produk->nama }}"
                                        data-produk_id_update="{{ $dp->produk_id}}">  
                                        <i class="fa fa-edit fa-sm"></i>             
                                    </button>
                                    <a href="/kasir/detail_pesanan/delete/{{$dp->id}}" class="btn btn-danger btn-sm"> <i class="fa fa-trash fa-sm"></i> </a>
                                </td>

                                </tr>  
                            </tbody> 
                            <?php $total_harga = $total_harga + $dp->sub_harga  ?>               
                            @endforeach     
                            <tbody class="text-center">                      
                                <tr>
                                    <th scope="row" class="text-center">#</th>
                                    <td colspan="3">Total Harga</td>
                                    <td class="text-right"> Rp. <?php echo number_format($total_harga); ?> </td>
                                    <input type="hidden" id="total_harga" name="total_harga" value="<?php echo $total_harga; ?>">
                                </tr>                          
                            </tbody>
                        </table>
                    </div>

                    <div class="row"> <!-- Baris Pembayaran -->
                        <div class="col-md-8"> <!-- Jumlah Pembayaran Cash , change, piutang -->
                            <div class="row">
                                <div class="col-md-3">
                                    <p> <b> Pembayaran </b> </p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend" >
                                            <div class="input-group-text" > <b> ( Cash ) Rp. </b></div>
                                        </div>
                                        <input type="text" name="cash" id="cash" value=""  class="form-control text-right">
                                    </div>
                                </div>                                                 
                            </div><div class="row">
                                <div class="col-md-6 text-right"></div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group ">
                                        <div class="input-group-prepend" >
                                            <div class="input-group-text" > <b> Change </b></div>
                                        </div>
                                        <input type="text" id="change" name="change" value="0"  class="form-control text-right" readonly>
                                    </div> 
                                </div> 
                            </div>   
                            <div class="row">
                                <div class="col-md-6 text-right"></div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group ">
                                        <div class="input-group-prepend" >
                                            <div class="input-group-text" > <b> Piutang </b></div>
                                        </div>
                                        <input type="text" id="piutang" name="piutang" value="0" class="form-control text-right" readonly>
                                    </div> 
                                </div> 
                            </div>  

                            <input type="hidden" id="jenis" name="jenis" value="antar">
                            <input type="hidden" id="status" name="status" value=""> 
                            <input type="hidden" id="status_stok" name="status_stok" value="ready"> 
                            <input type="hidden" id="status_pengiriman" name="status_pengiriman" value="menunggu pengiriman"> 
           

                        </div>

                        <div class="col-md-4"> <!-- Tombol Buat Pesanan -->
                            <div class="text-right" style="font-size:20px;  font-family:segoe ui black; font-weight:bold;">
                                <a> <button type="submit" class="btn" style="background-color:#c4eb2a; width:200px;">
                                    <i class="fa fa-plus"></i> Buat Pesanan </button> 
                                </a> 
                            </div>
                        </div>
                    </div>

                    </form>   
                            
                </div>                                                  
            </div>  

        </section>
    </div>
</div>


            
<!-- Update  modal (detail pesanan) -->
    <div class="modal fade update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ubah jumlah produk yang akan dipesan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/kasir/detail_pesanan/update" method="post">     
                    <div class="modal-body">              
                        @csrf
                        @method('PATCH')    
                        <input type="hidden" name="id" id="id" value="">  
                        <input type="hidden" name="produk_id" id="produk_id_update" value="">  
                        <div class="container col-md-10">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text" style="width:120px" > <b>Nama Produk </b></div>
                                </div>
                                <input class="form-control" type="text" id="nama_update" value="" readonly>
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text" style="width:120px" > <b>Jumlah </b></div>
                                </div>
                                <input type="number" name="jumlah" id="jumlah_update" value="" min="1" class="form-control">
                            </div>
                        </div>                               
                    </div>
                
                    <div class="modal-footer">   
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>                               
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Penutup Update  modal -->


<!-- Create Modal (pelanggan)-->
    <div class="modal fade create_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title " id="exampleModalLabel">Tambah Pelanggan Baru </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/kasir/pelanggan/store" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="container">  
                            
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama Pelanggan </label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama" name="nama" >
                                </div>
                            </div>                     
                            
                            <div class="form-group row">
                                <label for="no_hp" class="col-sm-4 col-form-label">Nomor Handphone </label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_hp" name="no_hp" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email </label>
                                <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat"> Alamat Pelanggan </label>
                                <textarea class="form-control" id="alamat" rows="2" name="alamat" placeholder=""> </textarea>
                            </div> 
                        </div>    
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Penutup Create Modal -->



<script>
$(document).ready(function(){
    $(document).on('click','#update', function(){
        var id                  = $(this).data('id');
        var jumlah_update       = $(this).data('jumlah_update');    
        var nama_update         = $(this).data('nama_update');
        var produk_id_update    = $(this).data('produk_id_update');     
        $('#id').val(id); 
        $('#jumlah_update').val(jumlah_update);   
        $('#nama_update').val(nama_update);   
        $('#produk_id_update').val(produk_id_update);   
    });

    $("#cash").change(function(){
        var cash = $("#cash").val();
        var tagihan = $("#total_harga").val();
        
        var change = cash - tagihan;
        if (change >= 0 ) {
            $('#change').val(change); 
        } else { 
            $('#change').val(0); 
        }

        var piutang = tagihan - cash ;
        if (piutang <= 0) {
            $('#status').val('lunas')
        }  else {
            $('#status').val('belum lunas');
        }
        if ( piutang >=0 ) {
            $('#piutang').val(piutang);
        } else {
            $('#piutang').val(0);
        }

        //alert("pesanan berhasil di tambahkan ");
    });
    $("#pelanggan_id").on("change",function(){
        var id_customer = $('#pelanggan_id option:selected').attr("id_customer");
        var nama_customer = $('#pelanggan_id option:selected').attr("nama_customer");
        var no_hp_customer = $('#pelanggan_id option:selected').attr("no_hp_customer");
        var email_customer = $('#pelanggan_id option:selected').attr("email_customer");
        var alamat_customer = $('#pelanggan_id option:selected').attr("alamat_customer");
        $("#id_customer").text(id_customer);
        $("#nama_customer").text(nama_customer);
        $("#no_hp_customer").text(no_hp_customer);
        $("#email_customer").text(email_customer);
        $("#alamat_customer").text(alamat_customer);
    });

   // $("#status_stok").change(function(){
  //      var status_stok = $('input:radio[name=status_stok]:checked').val();
    //    alert(status_stok);
   // )};

   // $('input:radio[name=preorder]:nth(0)').attr('checked',true);
	//    alert('po');

  //  });
});
</script>


</body>
</html>
@endsection
