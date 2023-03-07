<div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu"> 
                    @if(auth()->user()->isOwner == true)
                        <li>
                            <a href="/dashboard-owner" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pesanan.index') }}" aria-expanded="false" class="{{Route::is('pesanan.index')? 'active' : ''}}">
                                <i class="icon-chart"></i><span class="nav-text">Data Pesanan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('produk.index') }}" aria-expanded="false">
                                <i class="icon-wallet"></i><span class="nav-text">Data Produk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('karyawan.index') }}" aria-expanded="false">
                                <i class="icon-people"></i><span class="nav-text">Admin</span>
                            </a>
                        </li>
                        
                    @else 
                        <li>
                            <a href="/dashboard-karyawan" aria-expanded="false" class="{{Route::is('produk.stokKosong')? 'active' : ''}}">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="{{Route::is('pesanan.index')? 'active' : ''}}">
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false" class="{{Route::is('pesanan.index')? 'active' : ''}}">
                                <i class="icon-basket-loaded"></i> <span class="nav-text">Pesanan</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('pesanan.index')}}">Data Pesanan</a></li>
                                <li><a href="{{route('pesanan.create')}}">Tambah Pesanan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-basket-loaded"></i> <span class="nav-text">Produk</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('produk.index')}}">Data Produk</a></li>
                                <li><a href="{{route('produk.getStok')}}">Tambah Stok</a></li>
                            </ul>
                        </li>
                    @endif

                        <li>
                            <a href="{{ route('pengeluaran.index') }}" aria-expanded="false" class="{{Route::is('pengeluaran.index')? 'active' : ''}}">
                                <i class="icon-wallet"></i><span class="nav-text">Pengeluaran</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('penjualan.index') }}" aria-expanded="false" class="{{Route::is('penjualan.index')? 'active' : ''}}">
                                <i class="icon-chart"></i><span class="nav-text">Laba Rugi</span>
                            </a>
                        </li>

                </ul>
            </div>
        </div>