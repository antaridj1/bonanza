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

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-5">Data Produk</h4>
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Harga Satuan</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($produks as $produk)
                            <tr> 
                                <td>{{$loop->iteration}}</td>
                                <td>{{$produk->nama}}</td>
                                <td>{{$produk->harga_satuan}}</td>
                                <td>{{$produk->stok}}</td>
                            </tr>
                            @endforeach
                            </tbody>
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