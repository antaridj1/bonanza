@extends('layout.app')

@section('title','Dashboard | UD. Bonanza Fish')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card gradient-4">
                    <a href="{{route('produk.stokKosong')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">Stok Kosong</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $stok_kosong }}</h2>
                                <p class="text-white mb-0">Hari Ini</p>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-archive"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Pesanan</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $pesanan_per_tahun }}</h2>
                            <p class="text-white mb-0">Jan - Des 2023</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div>
                    <p class="text-muted">Pesanan Terakhir</p>
                </div>
                @if($pesanan !== null)
                    <div class="card border-primary">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <p><b>{{ $pesanan->nama }}</b> ({{$pesanan->telp}})</p>
                                    <small>{{$pesanan->created_at->format('d M Y')}}</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">  
                                <div class="card-body m-0 pt-0 pb-0 ">
                                    <table class="table table-borderless col-6">
                                        <tr>
                                            <td>ID</td>
                                            <td>: {{ $pesanan->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: {{$pesanan->alamat}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Pesanan</td>
                                            <td>: Rp {{number_format($pesanan->total_harga,0)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <small>Last updated {{ $pesanan->updated_at->diffForHumans()}}</small>
                                <div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
