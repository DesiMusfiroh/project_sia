<?php use App\Produk; ?>
<html>
    <head>
    </head>

    <body>
@extends('layouts.layout_owner')

@section('content')

<div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">

                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span>Produk Terjual</span>
                </div>

                <div class="card-body">
           
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-light text-center">
                            <tr>
                                <th scope="col" >No</th>
                                <th scope="col" >Produk</th>
                                <th scope="col" >Jumlah</th>     
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>                                                 
                            @foreach ($produk_terjual as $pro) 
                            <tr>
                                <td scope="row"  class="text-center"><?php  $i++;  echo $i; ?></td>
                                <td class="text-center">{{ $pro->produk->nama }}</td>
                                <td class="text-center">{{ $pro->jumlah_terjual }}</td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7 ">
            <div class="card justify-content-center">            
                <div class="card-header bg-dark text-center " style="font-size:20px; color:#c4eb2a; font-family:segoe ui black; font-weight:bold;"> 
                   <span> Grafik Produk Terjual</span>
                </div>
                <div class="card-body mr-3 ml-3">
                    <div id="produk_terjual" style="height: 350px;"></div>
                </div>            
            </div>  
        </div>
    </div>

@endsection

@section('chart')
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

      var analytics = <?php echo $produk; ?>;
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.arrayToDataTable(analytics);    
      var options = {
          chart: {
            title: '',      
          }
        };
      var chart = new google.charts.Bar(document.getElementById('produk_terjual'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    </script>
@endsection
</body>
</html>