<?php use App\Produk; ?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_gudang')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-right" style="font-size:20px; font-family:segoe ui black; font-weight:bold;">
                <a> <button type="button" class="btn" style="background-color:#c4eb2a;" data-toggle="modal" data-target=".create_modal" id="create">
                    [ <i class="fa fa-plus"></i> ]  Tambah Produk </button> 
                </a> 
            </div>

            <hr>

            <div class="card">

                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Daftar Produk</span>
                </div>

                <div class="card-body">
           
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

                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col" style="width:50px">No</th>
                                <th scope="col" style="width:150px">Kode Produk</th>
                                <th scope="col" style="width:300px">Nama Produk</th>
                                <th scope="col" style="width:400px">Deskripsi Produk</th>
                                <th scope="col" style="width:150px">Harga</th>
                                <th scope="col" style="width:140px"></th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>                                                 
                            @foreach ($produk as $pro) 
                            <tr>
                                <td scope="row"><?php  $i++;  echo $i; ?></td>
                                <td class="text-center">{{ $pro->kode }}</td>
                                <td>{{ $pro->nama }}</td>
                                <td>{{ $pro->deskripsi }}</td>
                                <td class="text-right">Rp. {{ number_format($pro->harga) }}</td>
                                                                         
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".update_modal"
                                        id="update"                                   
                                        data-id="{{ $pro->id }}"    
                                        data-kode_update="{{ $pro->kode }}"     
                                        data-nama_update="{{ $pro->nama }}"    
                                        data-harga_update="{{ $pro->harga }}"    
                                        data-stok="{{ $pro->stok }}"    
                                        data-deskripsi_update="{{ $pro->deskripsi }}">  
                                        <i class="fa fa-edit"></i>             
                                    </button>
                                
                                    <button class="btn btn-danger" data-toggle="modal" data-target=".delete_modal"
                                        id="delete"
                                        data-id_delete="{{ $pro->id }}"
                                        data-nama_delete="{{ $pro->nama }}">
                                        <i class="fa fa-trash"></i>                                       
                                    </button>
                                </td>                          
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



<!-- Create Modal -->
<div class="modal fade create_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="exampleModalLabel">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/gudang/produk/store" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">  
                        <div class="form-group row">
                            <label for="kode" class="col-sm-4 col-form-label">Kode Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="kode" name="kode" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga" class="col-sm-4 col-form-label">Harga Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="harga" name="harga" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_logo">Deskripsi Produk </label>
                            <textarea class="form-control" id="deskripsi" rows="2" name="deskripsi" placeholder=""> </textarea>
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
                <h5 class="modal-title" id="exampleModalLabel"> Update Data Produk </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/gudang/produk/update" method="post">
            <div class="modal-body">
                
                @csrf
                @method('PATCH')
                    <div class="container">
                     
                        <input type="hidden" name="id" id="id" value="">  
                        <input type="hidden" name="stok" id="stok" value="">  
                       
                        <div class="form-group row">
                            <label for="kode" class="col-sm-4 col-form-label">Kode Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control"  name="kode" id="kode_update" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama" id="nama_update" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga" class="col-sm-4 col-form-label">Harga Produk </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="harga_update" name="harga" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_logo">Deskripsi Produk </label>
                            <textarea class="form-control" id="deskripsi_update" rows="2" name="deskripsi" > </textarea>
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

<!-- Delete Modal -->
<div class="modal fade delete_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title " id="exampleModalLabel">Hapus Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/gudang/produk/delete" method="post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" value="" id="id_delete" >
                <p>Data Produk <b> <span id="nama_delete"></span>  </b> akan di hapus </p> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus Produk</button>
            </div>
        </form>
        </div>
    </div>
    </div>
<!-- Penutup Delete Modal -->

<script>
$(document).ready(function(){
    $(document).on('click','#update', function(){
        var id                  = $(this).data('id');
        var stok                = $(this).data('stok');
        var kode_update         = $(this).data('kode_update');
        var nama_update         = $(this).data('nama_update');
        var harga_update        = $(this).data('harga_update');
        var deskripsi_update    = $(this).data('deskripsi_update');
        $('#id').val(id); 
        $('#stok').val(stok);      
        $('#kode_update').val(kode_update);             
        $('#nama_update').val(nama_update);  
        $('#harga_update').val(harga_update);  
        $('#deskripsi_update').val(deskripsi_update);  
    });

    $(document).on('click','#delete', function(){
        var id_delete   = $(this).data('id_delete');    
        var nama_delete = $(this).data('nama_delete');   
        $('#id_delete').val(id_delete);
        $('#nama_delete').text(nama_delete);
    });     
});
</script>

@endsection

</body>
</html>