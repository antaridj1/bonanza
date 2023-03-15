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
                <h3>Laporan Pengeluaran {{request('year') ? 'Tahun '.request('year') : ''}}</h3>
                <h5>Alamat: Jl. Yeh Gangga I, Sudimara, Kec. Tabanan, Kabupaten Tabanan, Bali 82115</h5>
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
                        <th>Nama Pengeluaran</th>
                        <th>Biaya (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($pengeluarans as $pengeluaran)
                <tr> 
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pengeluaran->created_at->format('d M Y')}}</td>
                    <td>{{$pengeluaran->nama}}</td>
                    <td>{{number_format($pengeluaran->biaya,0)}}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-left" colspan="3">Subtotal (Rp)</th>
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
            <p><b>(Nengah Sukarena)</b></p>
        </div>
    </div>
</footer>
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