<div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu"> 
                    @if(auth()->user()->isOwner == false)
                        <li>
                            <a href="/dashboard-karyawan" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-label">Penjualan</li>
                        <li>
                            <a href="{{ route('penjualan.create') }}" aria-expanded="false">
                                <i class="icon-plus"></i><span class="nav-text">Tambah Data</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isOwner == true)
                        <li>
                            <a href="/dashboard-owner" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengeluaran.index') }}" aria-expanded="false">
                                <i class="icon-wallet"></i><span class="nav-text">Data Pengeluaran</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-basket-loaded"></i> <span class="nav-text">Barang</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('barang.index')}}">Daftar Barang</a></li>
                                <li><a href="{{route('barang.getStok')}}">Tambah Stok</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('karyawan.index') }}" aria-expanded="false">
                                <i class="icon-people"></i><span class="nav-text">Karyawan</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('penjualan.index') }}" aria-expanded="false">
                            <i class="icon-chart"></i><span class="nav-text">Data Penjualan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>