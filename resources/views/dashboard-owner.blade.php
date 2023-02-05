@extends('layout.app')

@section('title','Dashboard | UD. Arisya')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Penjualan</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($penjualan,0) }}</h2>
                            <p class="text-white mb-0">Jan - {{ $month }} {{ $year}}</p>
                        </div>
                        {{-- <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Profit</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($profit,0) }}</h2>
                            <p class="text-white mb-0">Jan - {{ $month }} {{ $year}}</p>
                        </div>
                        {{-- <span class="float-right display-5 opacity-5"><i class="fa fa-dollar"></i></span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Stok Kosong</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $stok_kosong }}</h2>
                            <p class="text-white mb-0">Hari Ini</p>
                        </div>
                        {{-- <span class="float-right display-5 opacity-5"><i class="fa fa-archive"></i></span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card gradient-4">
                    <div class="card-body">
                        <h3 class="card-title text-white">Barang Terjual </h3>
                        <div class="d-inline-block">
                            @if ($barang !== null)
                            <h2 class="text-white">{{ $barang }}</h2>
                            @else
                            <h2 class="text-white">0</h2>
                            @endif
                            <p class="text-white mb-0">Jan - {{ $month }} {{ $year}}</p>
                        </div>
                        {{-- <span class="float-right display-5 opacity-5"><i class="fa fa-cart-arrow-down"></i></span> --}}
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="card col-lg-12 col-md-12 col-sm-12">
                <div class="card-body">
                        <h4 class="card-title">Grafik Barang Terjual Tahun {{ $year }}</h4>
                    <div id="distributed-series" class="ct-chart ct-golden-section"></div>
                </div>
            </div>
            {{-- <div class="card col-lg-12 col-md-12 col-sm-12">
                <div class="card-body">
                    <h4 class="card-title">Grafik Barang Terjual Tahun {{ $year }}</h4>
                    <canvas id="singelBarChart" width="500" height="250"></canvas>
                </div>
            </div> --}}
            <div class="card col-lg-12 col-md-12 col-sm-12">
                <div class="card-body">
                    <h4 class="card-title">Grafik Laba Rugi Tahun {{ $year }}</h4>
                    
                    <div id="bi-polar-bar" class="ct-chart ct-golden-section"></div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    
   //Distributed series
$.get("{{ route('getBarangs') }}",function([barangs,jumlah]){
    new Chartist.Bar('#distributed-series', {
        labels: barangs,
        series: jumlah
    }, {
        distributeSeries: true,
        plugins: [
        Chartist.plugins.tooltip()
        ]
    });
});
</script>

<script>
$.get("{{ route('getProfit') }}",function(profits){
    var data = {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Okt','Nov','Des'],
        series: profits
    };
    
    var options = {
        
        onlyInteger: true,
        axisX: {
        labelInterpolationFnc: function(value, index) {
            return value;
        }
        },
        plugins: [
        Chartist.plugins.tooltip()
        ]
    };
    
    new Chartist.Bar('#bi-polar-bar', data, options);
});

// single bar chart
// $.get("{{ route('getBarangs') }}",function([barangs,jumlah]){
// var ctx = document.getElementById("singelBarChart");
//     ctx.height = 150;
//     var myChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: barangs,
//             datasets: [
//                 {
//                     label: "Barang",
//                     data: jumlah,
//                     borderColor: "rgba(117, 113, 249, 0.9)",
//                     borderWidth: "0",
//                     backgroundColor: "rgba(117, 113, 249, 0.5)"
//                 }
//             ]
//         },
//         options: {
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero: true
//                     }
//                 }]
//             }
//         }
//     });
// });

</script>

@endpush
@endsection
