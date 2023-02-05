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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Barang</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Data</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form-valide" action="{{route('barang.postStok')}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="search">Barang<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="form-group mt-2">
                                            <select class="form-control @error('barang') is-invalid @enderror" 
                                                aria-label=".form-select-sm example"
                                                id="select_barang" name="nama">
                                                    <option value="">-- Tambahkan Barang --</option>
                                                @foreach ($barangs as $barang)
                                                    @if($barang->ukuran !== null)
                                                        <option value="{{ $barang->id }}">{{ $barang->nama }} {{ $barang->ukuran }}</option>
                                                    @else
                                                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div> 
                                        @error('barang')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="stok">Jumlah Stok<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ @old('stok') }}">
                                        @error('stok')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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