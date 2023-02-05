@extends('layout.app')

@section('title','Karyawan | UD. Arisya')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')

<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Karyawan</a></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Karyawan</h4>
                        <div class="d-flex justify-content-between">
                            <form action="{{route('karyawan.index')}}">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border" type="search" placeholder="Search" id="example-search-input" aria-describedby="button-addon2" name="search" value="{{request('search')}}">
                                    <span class="input-group-append">
                                        <button class="btn btn-outline-secondary border-start-0 border-bottom-0 border" type="submit" >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <a href="{{route('karyawan.create')}}" class="btn btn-primary mt-2 mb-3">
                                Tambah Karyawan
                            </a>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Telp</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($karyawans as $karyawan)
                            <tr> 
                                <td>{{$loop->iteration}}</td>
                                <td>{{$karyawan->nama}}</td>
                                <td>{{$karyawan->telp}}</td>
                                <td>{{$karyawan->alamat}}</td>
                                <td>
                                    @if ($karyawan->status == 1)
                                      <a href="{{ route('karyawan.editStatus', $karyawan->id) }}" class="label label-success"
                                          data-toggle="modal" data-target="#editStatus_{{$karyawan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Nonatifkan">
                                          Aktif
                                      </a> 
                                    @else
                                      <a href="{{ route('karyawan.editStatus', $karyawan->id) }}" class="label label-danger"
                                          data-toggle="modal" data-target="#editStatus_{{$karyawan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Aktifkan">
                                          Nonaktif
                                      </a>
                                    @endif
                                      <div class="modal fade" id="editStatus_{{$karyawan->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              @if($karyawan->status == 1)
                                                <h4 class="modal-title">Nonaktifkan Akun</h4>
                                              @else
                                                <h4 class="modal-title">Aktifkan Akun</h4>
                                              @endif
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                              <form method="post" action="{{route('karyawan.editStatus',$karyawan->id)}}">
                                                @method('put')
                                                @csrf
                                                <div class="form-group"> 
                                                  @if($karyawan->status == 1)
                                                    <p>Saat ini akun karyawan sedang dalam keadaan Aktif. Apakah Anda yakin untuk menonaktifkan akun ini?</p>
                                                  @else
                                                    <p>Saat ini akun karyawan sedang dalam keadaan Nonaktif. Apakah Anda yakin untuk mengaktifkan akun ini?</p>
                                                  @endif
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
                                    <td>
                                      <div>
                                        <a href="{{ route('karyawan.delete',$karyawan->id) }}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletekaryawan_{{$karyawan->id}}"
                                              data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                             Hapus
                                        </a>
                                        <div class="modal fade" id="deletekaryawan_{{$karyawan->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('karyawan.delete',$karyawan->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <div class="form-group"> 
                                                            <p>Apakah Anda yakin ingin menghapus data karyawan?</p>
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
                                    </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{$karyawans->links()}}
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