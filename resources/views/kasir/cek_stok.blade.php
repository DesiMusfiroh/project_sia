<?php 
    use App\Produk; 
    use App\Stok; 
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

    <div class="col-md-7">
        <div class="row">
            <div class="col-md-5 ml-auto">
                <form action="/kasir/produk/cari" method="GET">
                    @csrf                    
                    <div class="input-group mb-2">                      
                        <input type="text" name="cari" placeholder="Cari Produk " value="{{ old('cari') }}" class="form-control"><br>
                        <div class="input-group-prepend" >                
                            <button  type="submit" class="btn btn-md btn-outline-primary" >   <i class="fa fa-search"></i> Cari  </button>                 
                        </div>
                    </div>
                </form>

            </div>
        </div>
       
        <div class="card">
            <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                <span> <i class="fa fa-cubes"></i> Cek Stok Produk</span>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-light text-center">
                        <tr>
                            <th scope="col" style="width:50px">No</th>
                            <th scope="col" style="width:150px">Kode Produk</th>
                            <th scope="col" style="width:300px">Nama Produk</th>
                            <th scope="col" style="width:150px">Harga</th>
                            <th scope="col" style="width:140px">Jumlah Stok</th>                             
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; ?>                                                 
                        @foreach ($produk as $pro) 
                        <tr>
                            <td scope="row" class="text-center"><?php  $i++;  echo $i; ?></td>
                            <td class="text-center">{{ $pro->kode }}</td>
                            <td>{{ $pro->nama }}</td>
                            <td class="text-right">Rp. {{ number_format($pro->harga) }}</td>                                                                        
                            <td class="text-center"> {{ $pro->stok}} </td>                          
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>

    </div>
   
</div>



@endsection
    </body>
</html>

<script>
$(document).ready(function(){

})
</script>