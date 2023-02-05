@extends('layout.app')

@section('title','Profil | UD. Arisya')

@section('container')

@include('layout.navbar')
@include('layout.sidebar')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profil</a></li>
            </ol>
        </div>
    </div>
            <!-- row -->
 @foreach($users as $user)
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            @if (Auth::user()->isOwner == true)
                                <h4 class="card-title">Profil Owner</h4>
                            @else
                                <h4 class="card-title">Profil Karyawan</h4>
                            @endif
                            <button class="btn btn-primary" data-toggle="modal" data-target="#edit_{{$user->id}}">
                                <i class="fa fa-edit"></i>
                            </button>
                        </div>
                        <table class="table table-borderless">
                            <tr>
                                <td>Nama</td>
                                <td>: {{$user->nama}}</td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>: {{$user->username}}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: {{$user->alamat}}</td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td>: {{$user->telp}}</td>
                            </tr>
                        </table>

                        <!-- Modal edit data -->
                        <div class="modal fade" id="edit_{{$user->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Data</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method="post" action="{{route('karyawan.update',$user->id)}}">
                                    @method('patch')
                                    @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="id" value="{{$user->id}}" name="id" hidden>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{$user->nama}}" name="nama" >
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" value="{{$user->username}}" name="username" >
                                            @error('username')
                                                <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="telp">No. Telp</label>
                                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" value="{{$user->telp}}" name="telp">
                                            @error('telp')
                                                <div class="invalid-feedback">
                                                {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" value="{{$user->alamat}}" name="alamat">
                                            @error('alamat')
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
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#edit_pass_{{$user->id}}">
                                Ubah Password
                            </button>
                                <!-- Modal edit pass -->
                                <div class="modal fade" id="edit_pass_{{$user->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ubah Password</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form method="post" action="{{route('editpass',$user->id)}}">
                                            @method('put')
                                            @csrf
                                                <div class="form-group mt-2">
                                                    <label for="password_lama">Password Lama</label>
                                                    <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" >
                                                    @error('password_lama')
                                                        <div class="invalid-feedback">
                                                        {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password_baru">Password Baru</label>
                                                    <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" >
                                                    @error('password_baru')
                                                        <div class="invalid-feedback">
                                                        {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="konfirmasi">Konfirmasi Password</label>
                                                    <input type="password" class="form-control @error('konfirmasi') is-invalid @enderror" id="konfirmasi" name="konfirmasi">
                                                    @error('konfirmasi')
                                                        <div class="invalid-feedback">
                                                        {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-4"> 
                                                    <button type="submit" class="btn btn-primary">Simpan </button>
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
    </div>
    @endforeach
</div>

@if(session()->has('status'))
    @include('layout.alert')
@endif
@endsection
