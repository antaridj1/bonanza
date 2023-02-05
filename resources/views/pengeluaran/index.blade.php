@extends('layout.app')

@section('title','Pengeluaran | UD. Arisya')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">pengeluaran</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Pengeluaran</h4>
                        <div class="d-flex justify-content-end">
                            <form action="{{route('pengeluaran.index')}}">
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
                                <a href="{{ route('pengeluaran.cetak') }}" class="btn btn-secondary shadow-sm mx-2">Cetak PDF</a>
                            </div>
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#ModalTambah">
                                Tambahkan Pengeluaran
                            </button>
                        
                        </div>
                        {{-- tabel --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Biaya (Rp)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($pengeluarans as $pengeluaran)
                                <tr> 
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$pengeluaran->created_at->format('d M Y')}}</td>
                                    <td>{{$pengeluaran->nama}}</td>
                                    <td>{{number_format($pengeluaran->biaya,0)}}</td>
                                    <td>
                                        <a href="{{route('pengeluaran.index', $pengeluaran->id)}}" class="label label-secondary m-1" data-toggle="modal" data-target="#edit_{{$pengeluaran->id}}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <div class="modal fade" id="edit_{{$pengeluaran->id}}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Data</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <div class="modal-body text-left">
                                                <form method="post" action="{{route('pengeluaran.update', $pengeluaran->id)}}">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="nama">Nama Pengeluaran</label>
                                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ $pengeluaran->nama }}" id="nama" name="nama" >
                                                        @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="biaya">Biaya</label>
                                                        <input type="text" min="1" class="form-control @error('biaya') is-invalid @enderror" value="{{ $pengeluaran->biaya }}" id="biaya" name="biaya" >
                                                        @error('biaya')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mt-4"> 
                                                        <button type="submit" class="btn btn-primary" >Simpan </button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <a href="{{route('pengeluaran.delete', $pengeluaran->id)}}" class="label label-danger m-1" 
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"  data-toggle="modal" data-target="#delete_{{$pengeluaran->id}}">
                                        <i class="fa fa-trash"></i>
                                        </a>
                                        <div class="modal fade" id="delete_{{$pengeluaran->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <form method="post" action="{{route('pengeluaran.delete',$pengeluaran->id)}}">
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

                        <!-- Modal Tambah pengeluaran-->
                        <div class="modal fade" id="ModalTambah">
                            <div class="modal-dialog">
                                <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Tambah Data</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                            
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method="post" action="{{route('pengeluaran.store')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nama">Nama Pengeluaran</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ @old('nama') }}" id="nama" name="nama" >
                                            @error('nama')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="biaya">Biaya</label>
                                            <input type="text" min="1" class="form-control @error('biaya') is-invalid @enderror" value="{{ @old('biaya') }}" id="biaya" name="biaya" >
                                            @error('biaya')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-4"> 
                                            <button type="submit" class="btn btn-primary" >Simpan </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{$pengeluarans->links()}}
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