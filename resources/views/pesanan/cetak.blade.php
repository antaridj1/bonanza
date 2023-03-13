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
    <header>
        <div class="row text-center">
            <div class="col-12">
                <img src="{{asset('assets/images/color-logo.svg')}}" class="mb-2" width="300px" alt="">
                <h3>Laporan Pesanan {{request('year') ? 'Tahun '.request('year') : ''}}</h3>
                <h5>Alamat: Jalan imam bonjol gang segina utara no 1</h5>
                <h5>Telp: 0361-480998</h5>
            </div>
            
        </div>
    </header>
    <hr style="border: 1px solid rgb(114, 114, 114);">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Alamat Customer</th>
                        <th>Status</th>
                        <th>Total Pembelian(Rp)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($pesanans as $pesanan)
                <tr> 
                    <td>{{$loop->iteration}}</td>
                    <td>{{Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y')}}</td>
                    <td>{{$pesanan->nama}}</td>
                    <td>{{$pesanan->alamat}}</td>
                    <td>{{$pesanan->status == true ? 'Sudah Diproses' : 'Belum Diproses'}}</td>
                    <td>{{number_format($pesanan->total_harga,0)}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-left" colspan="5">Subtotal (Rp)</th>
                        <th>{{number_format($total,0)}}</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
    <footer class="mt-5">
        <div class="row d-flex justify-content-end">
            <div class="col-4 text-center">
                <p><b>Mengetahui,</b></p>
                <p style="margin-bottom:100px"><b>Pemilik UD. Bonanza Fish</b></p>
                <p><b>.............................................</b></p>
            </div>
        </div>
    </footer>
<script type="text/javascript">
    window.print();
    window.onafterprint = function() {
        
        history.go(-1);
    }; 
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="{{asset('assets/plugins/common/common.min.js')}}"></script>
<script src="{{asset('assets/js/custom.min.js')}}"></script>

</body>

</html>