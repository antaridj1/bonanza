@extends('layout.app')

@section('title','Pesanan | UD. Bonanza Fish')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')


<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <div>
                <h4 class="d-inline" style="color: black;">Data Pesanan</h4>
                @if(auth()->user()->isOwner == false)
                    <p class="text-muted">Anda telah menangani sebanyak {{ $pesanans->count() }} pesanan </p>
                @else
                    <p class="text-muted">Total pesanan sebanyak {{ $pesanans->count() }} pesanan </p>
                @endif
            </div>
        </div>
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">pesanan</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <div class="row">
                        <div class="col-4">
                            <span>Filter data dari tanggal:</span>
                        </div>
                        <div class="col-8 mb-3">
                            <form action="/pesanan">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif 
                                <div class="d-flex justify-content-center">
                                    <input class="form-control border-end-0 border input-daterange-datepicker " type="text" 
                                        name="daterange" value="{{ ($date == null)? '' : $date }} ">
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary border-start-0 border-bottom-0 border" type="submit" >
                                            <i class="fa fa-filter"></i>  Filter
                                        </button>
                                    </span>
                                
                            </div>
                        </form>
                        </div>
                </div>
                    <div class="d-flex">
                        @if(auth()->user()->isOwner == true)
                        <div class="dropdown">
                            <a href="{{ route('pesanan.cetak') }}" class="btn btn-secondary shadow-sm mr-2">Cetak PDF</a>
                        </div>
                        @endif
                        
                        <form action="/pesanan">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif 
                            <div class="input-group">
                                <div class="d-flex justify-content-center">
                                    <input class="form-control border-end-0 border" type="search" placeholder="Search" id="example-search-input" aria-describedby="button-addon2" name="search" value="{{request('search')}}">
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary border-start-0 border-bottom-0 border" type="submit" >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($pesanans->count() == 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Tidak Ada Data</p>
                            </div>
                        </div>
                    </div>
                @else
                @foreach($pesanans as $pesanan) 
                <div class="card border-primary ">
                    <a href="pesanan/{{$pesanan->id}}" data-toggle="modal" data-target="#detail_{{$pesanan->id}}" class="pesanan">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <p><b>{{ $pesanan->nama }}</b> ({{$pesanan->telp}})</p>
                                <small>{{$pesanan->created_at->format('d/m/Y')}}</small>
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
                                        <td>Tanggal Pemesanan</td>
                                        <td>: {{$pesanan->tanggal_pemesanan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Pesanan</td>
                                        <td>: Rp {{number_format($pesanan->total_harga,0)}}</td>
                                    </tr>
                                    @if(auth()->user()->isOwner == true)
                                        <tr>
                                            <td>Penanggungjawab</td>
                                            <td>: {{$pesanan->karyawan->nama}}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="d-flex align-items-center"> 
                                <i class="icon-arrow-right p-2"></i>
                            </div>
                        </div>
                    </a>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <small>Dibuat {{ $pesanan->created_at->diffForHumans()}}</small>
                            @if(auth()->user()->isOwner == false)
                                <div>
                                    <a href="{{ route('pesanan.delete',$pesanan->id) }}" data-toggle="modal" data-target="#deletepesanan_{{$pesanan->id}}"
                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="icon-trash p-3"></i>
                                    </a>
                                    <div class="modal fade" id="deletepesanan_{{$pesanan->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('pesanan.delete',$pesanan->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="form-group"> 
                                                        <p>Apakah Anda yakin ingin menghapus data pesanan?</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary" >Hapus </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="detail_{{$pesanan->id}}">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Detail Pesanan</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
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
                                        <td>Tanggal Pemesanan</td>
                                        <td>: {{$pesanan->tanggal_pemesanan}}</td>
                                    </tr>
                                    @if(auth()->user()->isOwner == true)
                                        <tr>
                                            <td>Penanggungjawab</td>
                                            <td>: {{$pesanan->karyawan->nama}}</td>
                                        </tr>
                                    @endif
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
                                            <td>{{ $produk->produk->nama }}</td>
                                            <td>{{ $produk->jumlah }} Kg</td>
                                            <td class="text-right">{{ number_format($produk->produk->harga_satuan,0) }}</td>
                                            @php
                                                $tot = $produk->produk->harga_satuan * $produk->jumlah;
                                            @endphp
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
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@if(session()->has('status'))
    @include('layout.alert')
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();   
        });
</script>
@endsection