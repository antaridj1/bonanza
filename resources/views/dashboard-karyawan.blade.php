@extends('layout.app')

@section('title','Dashboard | UD. Bonanza Fish')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <a href="{{route('produk.stokKosong')}}">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">Stok Kosong</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $stok_kosong }}</h2>
                                <p class="text-white mb-0">Hari Ini</p>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-archive"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-sm-12">
                <a href="{{route('pesanan.index')}}">
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
                </a>
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
                                @if ($pesanan->status == false)
                                        <button type="button" class="btn btn-danger btn-xs ms-3 shadow-sm" data-toggle="modal" 
                                            data-target="#editStatus_{{$pesanan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                            Belum Diproses
                                        </button>
                                        <div class="modal fade" id="editStatus_{{$pesanan->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Status</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('pesanan.editStatus',$pesanan->id) }}">
                                                        @method('patch')
                                                        @csrf
                                                        <div class="form-group"> 
                                                            <p>Apakah Anda akan memproses pesanan ini?</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary" >Proses Sekarang </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    @elseif($pesanan->status == 2)
                                        <button type="button" class="btn btn-warning btn-xs ms-3 shadow-sm" data-toggle="modal" 
                                                data-target="#editStatus_{{$pesanan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                                Sedang Diproses
                                        </button>
                                        <div class="modal fade" id="editStatus_{{$pesanan->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Status</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('pesanan.editStatus',$pesanan->id) }}">
                                                        @method('patch')
                                                        @csrf
                                                        <div class="form-group"> 
                                                            <p>Anda hanya bisa mengubah status sekali jika pesanan telah diproses. Apakah pesanan sudah diproses?</p>
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
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
