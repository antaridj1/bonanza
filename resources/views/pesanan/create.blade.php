@extends('layout.app')

@section('title','Pesanan | UD. Bonanza Fish')

@section('container')


@include('layout.navbar')
@include('layout.sidebar')
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pesanan</a></li>
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
                            <form class="form-valide" action="{{route('pesanan.store')}}" method="post">
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
                                    <label class="col-lg-4 col-form-label" for="tanggal_pemesanan">Tgl Pemesanan<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="date" class="form-control @error('tanggal_pemesanan') is-invalid @enderror" id="tanggal_pemesanan" name="tanggal_pemesanan" value="{{ @old('tanggal_pemesanan') }}">
                                        @error('tanggal_pemesanan')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="search">Produk<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="form-group mt-2">
                                            <div class="d-flex">
                                                <select class="form-control @error('produk') is-invalid @enderror" 
                                                    aria-label=".form-select-sm example"
                                                    id="select_produk">
                                                        <option value="">-- Tambahkan Produk --</option>
                                                    @foreach ($produks as $produk)
                                                        <option value="{{ $produk->id }}" {{($produk->stok < 10)? 'disabled="true" style=color:#ee0000 !important;' : ''}}>{{ $produk->nama }} ({{$produk->stok}})</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-secondary" id="button_produk" type="button" >
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div> 
                                        @error('produk')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th class="text-center">Jumlah (kg)</th>
                                            <th class="text-right">Harga (Rp)</th>
                                            <th class="text-right">Total (Rp)</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_produk">

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
{{-- <script src="{{asset('assets/js/produk.js')}}"></script> --}}

<script>
$(document).ready(function(){
    
    $("#button_produk").click(function(){
        $.get("{{ route('pesanan.getProduk') }}",function(produks){
            let reqproduk = $("#select_produk").val();
            const tabel = $("#tabel_produk");
            $.each(produks, function(i,produk){
                let reqNama = $("#select_produk").find('option:selected').text();
                if( produk.id == reqproduk){

                    tabel.append(
                        `<tr id="${parseInt(i)+1}">
                            <td>${produk.nama}<input type="hidden" name="produk[]" value="${produk.id}"></td>
                            <td><div class="d-flex">
                                <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-dark qty-min" type="button"> <i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="text" readonly class="form-control input-group-sm input" style="height:auto; width:10px;" min="10" value="10" name="jumlah[]">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-dark qty-plus" type="button"> <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </td>
                            <td class="harga_satuan text-right">${produk.harga_satuan}</td>
                            <td class="total text-right">${produk.harga_satuan}</td>
                            <td class="hapus text-center"><i class="fa fa-trash"></i></td>
                        </tr>`
                    );
                    $("#select_produk").find(`option[value='${produk.id}']`).attr('disabled',true);
                    $("#select_produk").find(`option[value='${produk.id}']`).css('color','#abafb3')
                    
                    var tr = tabel.find(`tr[id=${parseInt(i)+1}]`);
                    getSubtotal();

                    tr.find('.qty-plus').click(function(){
                        var oldValue = $(this).parent().parent().find('.input').val();
                        if(oldValue < produk.stok){
                            $(this).parent().parent().find('input').val(parseInt(oldValue) + 10)
                            var harga = tr.find('.harga_satuan').text();
                            var jml = $(this).parent().parent().find('input').val();
                            var total = parseInt(jml) * parseInt(harga) / 10;
                            tr.find('.total').text(total);

                        getSubtotal();
                        }
                    })

                    tr.find('.qty-min').click(function(){
                        var oldValue = $(this).parent().parent().find('.input').val();
                        if(oldValue > 10){
                            $(this).parent().parent().find('input').val(parseInt(oldValue) - 10)
                            var harga = tr.find('.harga_satuan').text();
                            var jml = $(this).parent().parent().find('input').val();
                            var total = parseInt(jml) * parseInt(harga) / 10;
                            tr.find('.total').text(total);

                            getSubtotal();
                        }
        
                    })

                    tr.find('.hapus').click(function(){
                        tr.remove();
                        getSubtotal();
                        $("#select_produk").find(`option[value='${produk.id}']`).attr('disabled',false);
                        $("#select_produk").find(`option[value='${produk.id}']`).css('color','#495057')
                    });
                }
            });

            function getSubtotal(){
                let sub = $('.total');
                var subtotal = 0;
                $.each(sub, function(index, value){
                    subtotal += parseInt(sub.eq(index).text());
                });
                $('#subtotal').text(subtotal);
                $('#totalHarga').val(subtotal);
            }

        });

            
        });
    

});
    
</script>
@endsection