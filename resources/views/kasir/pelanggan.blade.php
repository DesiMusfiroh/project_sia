<?php use App\Pelanggan; ?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_kasir')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-right" style="font-size:20px; font-family:segoe ui black; font-weight:bold;">
                <a> <button type="button" class="btn" style="background-color:#c4eb2a;" data-toggle="modal" data-target=".create_modal" id="create">
                    [ <i class="fa fa-plus"></i> ]  Tambah Pelanggan </button> 
                </a> 
            </div>

            <hr>

            <div class="card">

                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Data pelanggan</span>
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
                                <th scope="col" style="width:300px">Nama </th>
                                <th scope="col" style="width:400px">Alamat</th>
                                <th scope="col" style="width:150px">Nomor HP</th>
                                <th scope="col" style="width:140px">Email</th>
                                <th scope="col" style="width:140px"></th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>                                                 
                            @foreach ($pelanggan as $pel) 
                            <tr>
                                <td scope="row"><?php  $i++;  echo $i; ?></td>
                                <td class="text-center">{{ $pel->nama }}</td>
                                <td>{{ $pel->alamat }}</td>
                                <td>{{ $pel->no_hp }}</td>
                                <td class="text-right">{{ $pel->email }}</td>
                                                                         
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".update_modal"
                                        id="update"                                   
                                        data-id="{{ $pel->id }}"  
                                        data-nama_update="{{ $pel->nama }}"    
                                        data-alamat_update="{{ $pel->alamat }}"    
                                        data-no_hp_update="{{ $pel->no_hp }}"    
                                        data-email_update="{{ $pel->email }}" >  
                                        <i class="fa fa-edit fa-sm"></i>             
                                    </button>
                                
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target=".delete_modal"
                                        id="delete"
                                        data-id_delete="{{ $pel->id }}"
                                        data-nama_delete="{{ $pel->nama }}">
                                        <i class="fa fa-trash fa-sm"></i>                                       
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



<!-- Create Modal -->
<div class="modal fade create_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title " id="exampleModalLabel">Tambah Pelanggan Baru</h5>
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

            
<!-- Update  modal -->
<div class="modal fade update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Update Data Pelanggan </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/kasir/pelanggan/update" method="post">
            <div class="modal-body">
                
                @csrf
                @method('PATCH')
                    <div class="container">
                     
                        <input type="hidden" name="id" id="id" value="">  

                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama" id="nama_update" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_hp" class="col-sm-4 col-form-label"> Nomor HP </label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="no_hp" id="no_hp_update" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label"> Email</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" id="email_update" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat </label>
                            <textarea class="form-control" name="alamat" rows="2" id="alamat_update" > </textarea>
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
            <h5 class="modal-title " id="exampleModalLabel">Hapus Data Pelanggan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/kasir/pelanggan/delete" method="post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id" value="" id="id_delete" >
                <p>Data Pelanggan <b> <span id="nama_delete"></span>  </b> akan di hapus </p> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus Pelanggan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
<!-- Penutup Delete Modal -->

<script>
$(document).ready(function(){
    $(document).on('click','#update', function(){
        var id         = $(this).data('id');
        var nama_update       = $(this).data('nama_update');
        var alamat_update     = $(this).data('alamat_update');
        var no_hp_update     = $(this).data('no_hp_update');
        var email_update     = $(this).data('email_update');
        $('#id').val(id); 
        $('#nama_update').val(nama_update);      
        $('#alamat_update').val(alamat_update);             
        $('#no_hp_update').val(no_hp_update);  
        $('#email_update').val(email_update);  
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