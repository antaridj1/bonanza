@extends('layout.app')

@section('title','Barang | UD. Arisya')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Barang</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Barang</h4>
                        <div class="d-flex justify-content-end">
                            <form action="{{route('barang.index')}}">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border" type="search" placeholder="Search" id="example-search-input" aria-describedby="button-addon2" name="search" value="{{request('search')}}">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary border-start-0 border-bottom-0 border" type="submit" >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <div class="dropdown">
                                <a href="{{ route('barang.cetak') }}" class="btn btn-secondary shadow-sm mx-2">Cetak PDF</a>
                            </div>
                            <a href="{{route('barang.create')}}" class="btn btn-primary mb-3">
                                Tambahkan Data
                            </a>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Ukuran</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Paket</th>
                                    <th>Jumlah per Paket</th>
                                    <th>Stok</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($barangs as $barang)
                            <tr> 
                                <td>{{$loop->iteration}}</td>
                                <td>{{$barang->nama}}</td>
                                <td>{{$barang->ukuran}}</td>
                                <td>{{number_format($barang->harga_satuan,0)}}</td>
                                <td>{{number_format($barang->harga_paket,0)}}</td>
                                <td>{{$barang->jumlah_paket}}</td>
                                <td>{{$barang->stok}}</td>
                                
                                <td><a href="{{route('barang.index', $barang->id)}}" class="label label-primary" 
                                    data-toggle="modal" data-target="#detail_{{$barang->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                    <i class="fa fa-search"></i>
                                    </a>
                                    <!-- The Modal -->
                                    <div class="modal fade" id="detail_{{$barang->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Keterangan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <p>{{$barang->keterangan}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{route('barang.edit', $barang->id)}}" class="label label-secondary m-1" 
                                     data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="{{route('barang.delete', $barang->id)}}" class="label label-danger m-1" 
                                     data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"  data-toggle="modal" data-target="#delete_{{$barang->id}}">
                                    <i class="fa fa-trash"></i>
                                    </a>
                                    <div class="modal fade" id="delete_{{$barang->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form method="post" action="{{route('barang.delete',$barang->id)}}">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="form-group"> 
                                                        <p>Apakah Anda yakin untuk menghapus data ini?</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary" >Ya </button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{$barangs->links()}}
                    </div>
                </div>
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