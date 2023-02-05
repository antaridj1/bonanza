@extends('layout.app')

@section('title','penjualan | UD. Arisya')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')


<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <div>
                <h4 class="d-inline" style="color: black;">Data Penjualan</h4>
                @if(auth()->user()->isOwner == false)
                    <p class="text-muted">Anda telah menangani sebanyak {{ $penjualans->count() }} transaksi </p>
                @else
                    <p class="text-muted">Total transaksi sebanyak {{ $penjualans->count() }} penjualan </p>
                @endif
            </div>
        </div>
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">penjualan</a></li>
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
                            <form action="/penjualan">
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
                        <div class="basic-dropdown">
                            <div class="dropdown">
                                @if(request('status') == "false")
                                    <button type="button" class="btn btn-secondary shadow-sm dropdown-toggle mr-2" data-toggle="dropdown">Belum Diproses</button>
                                @elseif (request('status') == "1")
                                    <button type="button" class="btn btn-secondary shadow-sm dropdown-toggle mr-2" data-toggle="dropdown">Sudah Diproses</button>
                                @else
                                    <button type="button" class="btn btn-secondary shadow-sm dropdown-toggle mr-2" data-toggle="dropdown">Semua</button>
                                @endif
                                <div class="dropdown-menu">
                                        <a class="dropdown-item" href="penjualan">Semua</a>
                                        <a class="dropdown-item" href="penjualan?status=false">Belum Diproses</a>
                                        <a class="dropdown-item" href="penjualan?status=1">Sudah Diproses</a>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->isOwner == true)
                        <div class="dropdown">
                            <a href="{{ route('penjualan.cetak') }}" class="btn btn-secondary shadow-sm mr-2">Cetak PDF</a>
                        </div>
                        @endif
                        <form action="/penjualan">
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
                @if($penjualans->count() == 0)
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Tidak Ada Data</p>
                            </div>
                        </div>
                    </div>
                @else
                @foreach($penjualans as $penjualan) 
                <div class="card border-primary ">
                    <a href="penjualan/{{$penjualan->id}}" data-toggle="modal" data-target="#detail_{{$penjualan->id}}" class="penjualan">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <p><b>{{ $penjualan->nama }}</b> ({{$penjualan->telp}})</p>
                                <small>{{$penjualan->created_at->format('d/m/Y')}}</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">  
                            <div class="card-body m-0 pt-0 pb-0 ">
                                <table class="table table-borderless col-6">
                                    <tr>
                                        <td>ID</td>
                                        <td>: {{ $penjualan->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: {{$penjualan->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Pembelian</td>
                                        <td>: Rp {{number_format($penjualan->total_harga,0)}}</td>
                                    </tr>
                                    @if(auth()->user()->isOwner == true)
                                        <tr>
                                            <td>Penanggungjawab</td>
                                            <td>: {{$penjualan->karyawan->nama}}</td>
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
                            <small>Last updated {{ $penjualan->updated_at->diffForHumans()}}</small>
                            @if(auth()->user()->isOwner == false)
                                <div>
                                    <a href="{{ route('penjualan.delete',$penjualan->id) }}" data-toggle="modal" data-target="#deletePenjualan_{{$penjualan->id}}"
                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="icon-trash p-3"></i>
                                    </a>
                                    <div class="modal fade" id="deletePenjualan_{{$penjualan->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('penjualan.delete',$penjualan->id) }}">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="form-group"> 
                                                        <p>Apakah Anda yakin ingin menghapus data penjualan?</p>
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
                                    @if ($penjualan->status == false)
                                        <button type="button" class="btn btn-danger btn-xs ms-3 shadow-sm" data-toggle="modal" 
                                            data-target="#editStatus_{{$penjualan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                            Belum Diproses
                                        </button>
                                        <div class="modal fade" id="editStatus_{{$penjualan->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Status</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('penjualan.editStatus',$penjualan->id) }}">
                                                        @method('patch')
                                                        @csrf
                                                        <div class="form-group"> 
                                                            <p>Anda hanya bisa mengubah status sekali jika penjualan telah diproses. Apakah penjualan sudah diproses?</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary" >Sudah Diproses </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="label label-pill label-success btn-xs">Sudah Diproses</span>
                                    @endif
                                    
                                </div>
                            @else
                                @if ($penjualan->status == false)
                                    <span class="label label-pill label-danger btn-xs">Belum Diproses</span>
                                @else
                                    <span class="label label-pill label-success btn-xs">Sudah Diproses</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="detail_{{$penjualan->id}}">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Detail Penjualan</h4>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
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
                                    @if(auth()->user()->isOwner == true)
                                        <tr>
                                            <td>Penanggungjawab</td>
                                            <td>: {{$penjualan->karyawan->nama}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Status</td>
                                        @if($penjualan->status == '1')
                                        <td>: Sudah Diproses</td>
                                        @else
                                        <td>: Belum Diproses</td>
                                        @endif

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