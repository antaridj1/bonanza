@extends('layout.app')

@section('title','penjualan | UD. Arisya')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')


<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Penjualan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Nota</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-inline">Nota Penjualan</h4>
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('penjualan.cetakNota') }}" class="btn btn-secondary shadow-sm mb-2">Cetak PDF</a>
                    </div>
                </div>

                <div class="card border-primary ">
                    <div class="card-body">
                        <table class="table table-borderless col-md-9 col-sm-12 ">
                            <tr>
                                <td>ID</td>
                                <td>: {{ $penjualan->id }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pembeli</td>
                                <td>: {{ $penjualan->nama }} ({{ $penjualan->telp }})</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{$penjualan->alamat}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembelian</td>
                                <td>: {{$penjualan->created_at->format('d M Y')}}</td>
                            </tr>
                        </table>
                        <table class="table col-12">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th class="text-right">Harga (Rp)</th>
                                    <th class="text-right">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tot = 0;
                                    $jml = 0;
                                @endphp
                                @foreach ($penjualan->detail_barang as $barang)
                                <tr>
                                    <td>{{ $barang->barang->nama }} {{ $barang->barang->ukuran }}</td>
                                    
                                    @if ($barang->satuan == "Buah")
                                        <td>{{ $barang->jumlah }} {{ $barang->satuan }}</td>
                                        <td class="text-right">{{ number_format($barang->barang->harga_satuan,0) }}</td>
                                        @php
                                            $tot = $barang->barang->harga_satuan * $barang->jumlah;
                                        @endphp
                                    @else
                                        @php
                                            $jml = $barang->jumlah/$barang->barang->jumlah_paket;
                                            $tot = $barang->barang->harga_paket * $jml;
                                        @endphp
                                        <td>{{ $jml }} {{ $barang->satuan }}</td>
                                        <td class="text-right">{{ number_format($barang->barang->harga_paket,0) }}</td>
                                        
                                    @endif
                                    <td class="text-right">{{ number_format($tot,0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">SUBTOTAL</th>
                                    <th class="text-right">Rp {{number_format($penjualan->total_harga,0)}}</th>
                                </tr>
                            </tfoot>
                        </table>         
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@if(session()->has('status'))
    @include('layout.alert')
@endif
@endsection