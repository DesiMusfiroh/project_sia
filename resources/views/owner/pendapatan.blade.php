<?php use App\Produk; use App\Pendapatan; ?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_owner')

@section('content')

    <div class="row justify-content-center">
       
        <div class="col-md-7">
            <div class="card">

                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Pendapatan</span>
                </div>

                <div class="card-body">
           
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col" >No</th>
                                <th scope="col" >Tanggal</th>
                                <th scope="col" >Penjualan</th>     
                                <th scope="col" >Piutang Pelanggan</th>     
                                <th scope="col" >Pendapatan</th>     
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; 
                                $total_pendapatan = 0; 
                                $total_penjualan = 0; 
                                $total_piutang_pelanggan = 0; 
                            ?>                                                 
                            @foreach ($pendapatan as $pen) 
                            <tr>
                                <td scope="row"  class="text-center"><?php  $i++;  echo $i; ?></td>
                                <td class="text-center">{{ $pen->tanggal_pesan }}</td>
                                <td class="text-center">Rp. {{ number_format($pen->penjualan) }}</td>
                                <td class="text-center">Rp. {{ number_format($pen->piutang_pelanggan) }}</td>
                                <td class="text-center">Rp. {{ number_format($pen->pendapatan) }}</td>
                            </tr>
                            <?php 
                                $total_pendapatan = $total_pendapatan + $pen->pendapatan; 
                                $total_penjualan = $total_penjualan + $pen->penjualan; 
                                $total_piutang_pelanggan = $total_piutang_pelanggan + $pen->piutang_pelanggan; 
                            ?>
                            @endforeach 
                        </tbody>
                       
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2">         
            <div class="card"> 
                <div class="card-header bg-warning text-center " style="font-size:13px; font-family:segoe ui black; font-weight:bold;"> 
                    <span> Total Pendapatan</span> 
                    <div style="font-size:20px">
                            <span >Rp. <?php echo number_format($total_pendapatan);?> </span>
                    </div>
                </div>           
            </div> <br>
            <div class="card"> 
                <div class="card-header bg-primary text-center " style="font-size:13px; font-family:segoe ui black; font-weight:bold;"> 
                    <span> Total Penjualan</span> 
                    <div style="font-size:20px">
                            <span >Rp. <?php echo number_format($total_penjualan);?> </span>
                    </div>
                </div>           
            </div> <br>
            <div class="card"> 
                <div class="card-header bg-danger text-center " style="font-size:13px; font-family:segoe ui black; font-weight:bold;"> 
                    <span> Total Piutang Pelanggan</span> 
                    <div style="font-size:20px">
                            <span >Rp. <?php echo number_format($total_piutang_pelanggan);?> </span>
                    </div>
                </div>           
            </div>
        </div>

    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card justify-content-center">
                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Grafik Pendapatan</span>
                </div>
                <div class="card-body mr-3 ml-3">
                    <div id="pendapatan" style="height: 300px;"></div>
                </div>
                
            </div>          
        </div>
    </div>

@endsection

@section('chart')
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

      var analytics = <?php echo $tabel; ?>;
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.arrayToDataTable(analytics);    
      var options = {
          chart: {
            title: '',      
          }
        };
      var chart = new google.charts.Bar(document.getElementById('pendapatan'));
      chart.draw(data, google.charts.Bar.convertOptions(options));

    }

    </script>

@endsection
</body>
</html>