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
                            <a href="{{ route('penjualan.index') }}" aria-expanded="false">
                                <i class="icon-chart"></i><span class="nav-text">Data Pemesanan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('barang.index') }}" aria-expanded="false">
                                <i class="icon-wallet"></i><span class="nav-text">Data Ikan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('karyawan.index') }}" aria-expanded="false">
                                <i class="icon-people"></i><span class="nav-text">Admin</span>
                            </a>
                        </li>
                        
                    @else 
                        <li>
                            <a href="/dashboard-karyawan" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-basket-loaded"></i> <span class="nav-text">Pemesanan</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('penjualan.index')}}">Data Pemesanan</a></li>
                                <li><a href="{{route('penjualan.create')}}">Tambah Pemesanan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-basket-loaded"></i> <span class="nav-text">Ikan</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('barang.index')}}">Data Ikan</a></li>
                                <li><a href="{{route('barang.getStok')}}">Tambah Stok</a></li>
                            </ul>
                        </li>
                    @endif

                        <li>
                            <a href="{{ route('pengeluaran.index') }}" aria-expanded="false">
                                <i class="icon-wallet"></i><span class="nav-text">Pengeluaran</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('penjualan.index') }}" aria-expanded="false">
                                <i class="icon-chart"></i><span class="nav-text">Penjualan</span>
                            </a>
                        </li>
                </ul>
            </div>
        </div>