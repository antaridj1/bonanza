<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak</title>
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title" style="text-indent: 25%">UD. ARISYA</h4>
            <h4 class="card-title mb-5" style="text-indent: 24%">Nota Penjualan</h4>
            <table class="table table-borderless col-5">
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
            </table>
            <table class="table col-7">
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

<script type="text/javascript">
    window.print();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="{{asset('assets/plugins/common/common.min.js')}}"></script>
<script src="{{asset('assets/js/custom.min.js')}}"></script>

</body>

</html>