@extends('layout.app')

@section('title','Penjualan | UD. Bonanza Fish')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laba Rugi</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Laba Rugi Tahun {{ (request('year'))?? Carbon\Carbon::now()->year}}</h4>
                        <div class="d-flex justify-content-end">
                            <form action="{{route('penjualan.index')}}">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border" type="search" placeholder="Search" id="example-search-input" aria-describedby="button-addon2" name="search" value="{{request('search')}}">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary border-start-0 border-bottom-0 border" type="submit" >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <div class="dropdown ml-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  {{ (request('year'))?? Carbon\Carbon::now()->year}}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($years as $year)
                                        <li><a class="dropdown-item" href="{{route('penjualan.index')}}?year={{$year}}">{{$year}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a href="{{ route('penjualan.cetak') }}" class="btn btn-secondary shadow-sm mx-2">Cetak PDF</a>
                            </div>
                        </div>
                        {{-- tabel --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Bulan</th>
                                        <th>Pemasukan (Rp)</th>
                                        <th>Pengeluaran (Rp)</th>
                                        <th>Laba/Rugi (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($penjualans as $penjualan)
                                <tr> 
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$penjualan['month']}}</td>
                                    <td>{{number_format($penjualan['pemasukan'],0)}}</td>
                                    <td>{{number_format($penjualan['pengeluaran'],0)}}</td>
                                    <td>{{number_format($penjualan['profit'],0)}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>{{number_format($data_pemasukan,0)}}</th>
                                        <th>{{number_format($data_pengeluaran,0)}}</th>
                                        <th>{{number_format($data_penjualan,0)}}</th>
                                    </tr>
                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection