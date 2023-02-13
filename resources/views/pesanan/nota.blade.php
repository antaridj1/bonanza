@extends('layout.app')

@section('title','pesanan | UD. Bonanza Fish')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')


<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah pesanan</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Nota</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="d-inline">Nota pesanan</h4>
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('pesanan.cetakNota') }}" class="btn btn-secondary shadow-sm mb-2">Cetak PDF</a>
                    </div>
                </div>

                <div class="card border-primary ">
                    <div class="card-body">
                        <table class="table table-borderless col-md-9 col-sm-12 ">
                            <tr>
                                <td>ID</td>
                                <td>: {{ $pesanan->id }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pembeli</td>
                                <td>: {{ $pesanan->nama }} ({{ $pesanan->telp }})</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{$pesanan->alamat}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pembelian</td>
                                <td>: {{$pesanan->created_at->format('d M Y')}}</td>
                            </tr>
                        </table>
                        <table class="table col-12">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
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
                                @foreach ($pesanan->detail_produk as $produk)
                                <tr>
                                    <td>{{ $produk->produk->nama }} {{ $produk->produk->ukuran }}</td>
                                    
                                    @if ($produk->satuan == "Buah")
                                        <td>{{ $produk->jumlah }} {{ $produk->satuan }}</td>
                                        <td class="text-right">{{ number_format($produk->produk->harga_satuan,0) }}</td>
                                        @php
                                            $tot = $produk->produk->harga_satuan * $produk->jumlah;
                                        @endphp
                                    @else
                                        @php
                                            $jml = $produk->jumlah/$produk->produk->jumlah_paket;
                                            $tot = $produk->produk->harga_paket * $jml;
                                        @endphp
                                        <td>{{ $jml }} {{ $produk->satuan }}</td>
                                        <td class="text-right">{{ number_format($produk->produk->harga_paket,0) }}</td>
                                        
                                    @endif
                                    <td class="text-right">{{ number_format($tot,0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">SUBTOTAL</th>
                                    <th class="text-right">Rp {{number_format($pesanan->total_harga,0)}}</th>
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