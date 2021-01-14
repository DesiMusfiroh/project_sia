<?php 
    use App\Produk;  
?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_gudang')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

    <hr>

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

        <div class="row">
        @foreach ($stok as $st) 
            <div class="col-sm-3 mb-4">
                <div class="card">
                    <div class="card-header bg-dark text-center " style="font-size:15px; color:#c4eb2a; font-family:segoe ui black; ">
                        {{ $st->nama}}
                    </div>
                    <div class="card-body text-center pt-0 pb-3" style="font-size:40px; font-family:segoe ui black; ">
                        <div class="pt-0 pb-0 mt-0 mb-0">
                            {{ $st->stok}}
                        </div>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".update_modal" id="update"                                   
                                data-id="{{ $st->id }}"     
                                data-nama="{{ $st->nama }}" 
                                data-stok="{{ $st->stok}}">  
                            <i class="fa fa-edit"></i> Update Stok         
                        </button>
                        
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>


<!-- Create Modal -->
<div class="modal fade create_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="exampleModalLabel">Tambah Stok Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/gudang/stok/store" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">  
                        
                        <div class="form-group row">
                            <label for="produk_nama" class="col-sm-4 col-form-label">Nama Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="produk_nama" name="produk_nama" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah" class="col-sm-4 col-form-label">Jumlah  </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" >
                            </div>
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

            
<!-- Update  modal -->
<div class="modal fade update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Update Data Stok Produk </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/gudang/produk/update" method="post">
            <div class="modal-body">
                
                @csrf
                @method('PATCH')
                    <div class="container justify-content-center">
                     
                        <input type="hidden" name="id" id="id" value="">  
                        <div class="text-center">
                            <p>  Update Stok Produk <b> <span id="nama"></span> </b> </p>
                        </div>
                        
                        <div class="form-group row">                         
                            <div class="input-group mb-2 mt-2 mr-5 ml-5 container">
                                <div class="input-group-prepend" >
                                    <div class="input-group-text" style="width:120px" > <b> Stok Terupdate </b></div>
                                </div>
                                <input type="number" name="stok" id="stok" value="stok" min="1" class="form-control text-center">
                            </div>
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

<script>
$(document).ready(function(){
    $(document).on('click','#update', function(){
        var id      = $(this).data('id');
        var stok    = $(this).data('stok');
        var nama    = $(this).data('nama');

        $('#id').val(id); 
        $('#stok').val(stok);      
        $('#nama').text(nama);             

    });
    
});
</script>


@endsection
    </body>
</html>