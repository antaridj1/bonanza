<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak</title>
    
    <!-- Favicon icon -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    

</head>

<body>
    <header>
        <div class="row text-center">
            <div class="col-12">
                <img src="{{asset('assets/images/color-logo.svg')}}" class="mb-2" width="300px" alt="">
                <h3>Laporan Produk {{request('year') ? 'Tahun '.request('year') : ''}}</h3>
                <h5>Alamat: Jl. Yeh Gangga I, Sudimara, Kec. Tabanan, Kabupaten Tabanan, Bali 82115</h5>
                <h5>Telp: 0361-480998</h5>
            </div>
            
        </div>
    </header>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Harga Satuan</th>
                                    <th>Stok Terjual</th>
                                    <th>Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($produks as $produk)
                                <tr> 
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$produk->nama}}</td>
                                    <td>{{$produk->harga_satuan}}</td>
                                    <td>{{$produk->produk_terjual !== null? $produk->produk_terjual : '0'}}</td>
                                    <td>{{$produk->stok}}</td>
                                </tr>
                            @endforeach
                            </tbody>
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