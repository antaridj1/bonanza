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
            <h4 class="card-title" style="text-indent: 25%">UD. Bonanza Fish</h4>
            <h4 class="card-title mb-5" style="text-indent: 24%">Nota Pesanan</h4>
            <table class="table table-borderless col-5">
                <tr>
                    <td>ID</td>
                    <td>: {{ $pesanan->id }}</td>
                </tr>
                <tr>
                    <td>Nama Pembeli</td>
                    <td>: {{ $pesanan->nama }} ({{ $pesanan->telp }})</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{$pesanan->alamat}}</td>
                </tr>
                <tr>
                    <td>Tanggal Pembelian</td>
                    <td>: {{$pesanan->created_at->format('d M Y')}}</td>
                </tr>
            </table>
            <table class="table col-7">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
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
                    @foreach ($pesanan->detail_produk as $produk)
                    <tr>
                        <td>{{ $produk->produk->nama }}</td>
                        <td>{{ $produk->jumlah }} Kg</td>
                        <td class="text-right">{{ number_format($produk->produk->harga_satuan,0) }}</td>
                        @php
                            $tot = $produk->produk->harga_satuan * $produk->jumlah;
                        @endphp
                        <td class="text-right">{{ number_format($tot,0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">SUBTOTAL</th>
                        <th class="text-right">Rp {{number_format($pesanan->total_harga,0)}}</th>
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