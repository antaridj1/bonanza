@extends('layout.app')

@section('title','Penjualan | UD. Arisya')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Penjualan</a></li>
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
                            <form class="form-valide" action="{{route('penjualan.store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="nama">Nama Pembeli <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ @old('nama') }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="telp">Telp Pembeli<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ @old('telp') }}">
                                        @error('telp')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="alamat">Alamat Pembeli<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ @old('alamat') }}">
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="search">Barang<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="form-group mt-2">
                                            <div class="d-flex">
                                                <select class="form-control @error('barang') is-invalid @enderror" 
                                                    aria-label=".form-select-sm example"
                                                    id="select_barang">
                                                        <option value="">-- Tambahkan Barang --</option>
                                                    @foreach ($barangs as $barang)
                                                        @if($barang->ukuran !== null)
                                                            <option value="{{ $barang->id }}">{{ $barang->nama }} {{ $barang->ukuran }}</option>
                                                        @else
                                                            <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="button_barang" type="button" >
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div> 
                                        @error('barang')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-right">Harga (Rp)</th>
                                            <th class="text-right">Total (Rp)</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_barang">

                                    </tbody>
                                    <tfoot>
                                        <tr class="border-top">
                                            <th>SUBTOTAL (Rp)</th>
                                            <th></th>
                                            <th></th>
                                            <th id="subtotal" class="text-right">0</th>
                                            <th><input type="hidden" id="totalHarga" name="total_harga"></th>
                                           
                                        </tr>
                                        
                                    </tfoot>
                                
                                </table>
                                <div class="form-group row">
                                    <div class="col-12 mt-5">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
         
                                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="{{asset('assets/js/barang.js')}}"></script> --}}

<script>
$(document).ready(function(){
    
    $("#button_barang").click(function(){
        $.get("{{ route('penjualan.getBarang') }}",function(barangs){
            let reqBarang = $("#select_barang").val();
            const tabel = $("#tabel_barang");
            $.each(barangs, function(i,barang){
                let reqNama = $("#select_barang").find('option:selected').text();
                    if( barang.id == reqBarang){
                            tabel.append(
                            '<tr id="'+barang.id+'">\
                                <td>'+reqNama+'<input type="hidden" name="barang[]" value="'+barang.id+'"></td>\
                                <td><div class="d-flex">\
                                        <input type="text" class="form-control input-group-sm input" style="height:auto" min="1" value="1" name="jumlah[]">\
                                        <select class="form-select custom-select" style="width:auto" name="satuan[]" aria-label=".form-select-sm example">\
                                            <option value="Buah">Buah</option>\
                                            <option value="Paket">Paket</option>\
                                        </select>\
                                    </div>\
                                </td>\
                                <td class="harga_satuan text-right">'+barang.harga_satuan+'</td>\
                                <td class="harga_paket text-right" style="display:none">'+barang.harga_paket+'</td>\
                                <td class="total text-right">'+barang.harga_satuan+'</td>\
                                <td class="hapus text-center"><i class="fa fa-trash"></i></td>\
                            </tr>'
                            );
                    }
            });

            //select satuan
            let tr = tabel.find('tr');

            function getSubtotal(){
                let sub = $('.total');
                var subtotal = 0;
                $.each(sub, function(index, value){
                    subtotal += parseInt(sub.eq(index).text());
                });
                $('#subtotal').text(subtotal);
                $('#totalHarga').val(subtotal);
            }

            $.each(tr, function(index, value){
                let harga_satuan = tr.eq(index).find('.harga_satuan');
                let harga_paket = tr.eq(index).find('.harga_paket');
                let harga_total = tr.eq(index).find('.total');
                let input = tr.eq(index).find('input[type=text]');
                let select = tr.eq(index).find('select');
                let hapus = tr.eq(index).find('.fa-trash');

                select.on('change',function(){
                    if(select.val() == "Paket"){
                        harga_satuan.hide();
                        harga_paket.show();
                        var harga = harga_paket.text();
                    }else{
                        harga_satuan.show();
                        harga_paket.hide();
                        var harga = harga_satuan.text();
                    }
                    let jml = input.val();
                    let total = jml * harga;
                    harga_total.text(total);

                    getSubtotal();
                });

                input.on('keyup',function(){
                    if(select.val() == "Paket"){
                        var harga = harga_paket.text();
                    }else{
                        var harga = harga_satuan.text();
                    }
                    let jml = input.val();
                    let total = jml * harga;
                    harga_total.text(total);

                    getSubtotal();
                });

                hapus.click(function(){
                    tr.eq(index).remove();
                    getSubtotal();
                });
            });

            getSubtotal();
        });
    });

});
    
</script>
@endsection