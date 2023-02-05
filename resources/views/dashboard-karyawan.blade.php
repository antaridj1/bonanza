@extends('layout.app')

@section('title','Dashboard | UD. Arisya')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Belum Diproses</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $jml_belum_proses }}</h2>
                            <p class="text-white mb-0">Penjualan</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Transaksi</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $penjualan_per_tahun }}</h2>
                            <p class="text-white mb-0">Jan - Des 2022</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div>
                    <p class="text-muted">Anda memiliki penjualan yang belum diproses</p>
                </div>
                @if($jml_belum_proses > 0)
                    <div class="card border-primary">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <p><b>{{ $belum_proses->nama }}</b> ({{$belum_proses->telp}})</p>
                                    <small>{{$belum_proses->created_at->format('d M Y')}}</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">  
                                <div class="card-body m-0 pt-0 pb-0 ">
                                    <table class="table table-borderless col-6">
                                        <tr>
                                            <td>ID</td>
                                            <td>: {{ $belum_proses->id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: {{$belum_proses->alamat}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Pembelian</td>
                                            <td>: Rp {{number_format($belum_proses->total_harga,0)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <small>Last updated {{ $belum_proses->updated_at->diffForHumans()}}</small>
                                <div>
                                    <button type="button" class="btn btn-danger btn-xs ms-3 shadow-sm" data-toggle="modal" 
                                        data-target="#editStatus_{{$belum_proses->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah Status">
                                        Belum Diproses
                                    </button>
                                    <div class="modal fade" id="editStatus_{{$belum_proses->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Status</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('penjualan.editStatus',$belum_proses->id) }}">
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
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div>
                    <p class="text-muted">Penjualan Terakhir Anda</p>
                </div>
                @if($penjualan !== null)
                    <div class="card border-primary">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <p><b>{{ $penjualan->nama }}</b> ({{$penjualan->telp}})</p>
                                    <small>{{$penjualan->created_at->format('d M Y')}}</small>
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
                                    </table>
                                </div>
                            </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <small>Last updated {{ $penjualan->updated_at->diffForHumans()}}</small>
                                <div>
                                    <span class="label label-pill label-success btn-xs">Sudah Diproses</span>
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
