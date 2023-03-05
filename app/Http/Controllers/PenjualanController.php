<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index(Request $request){
        $years = Pesanan::selectRaw('year(tanggal_pemesanan) year')->groupBy('year')->orderBy('year','DESC')->distinct()->pluck('year');
        $year = $request->year ?? Carbon::now()->year;

        $pengeluarans = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year, monthname(tanggal_pengeluaran) month, sum(biaya) as sum')
                    ->whereYear('tanggal_pengeluaran',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();
   
        $pemasukans = Pesanan::selectRaw('year(tanggal_pemesanan) year, monthname(tanggal_pemesanan) month, sum(total_harga) as sum')
                    ->whereYear('tanggal_pemesanan',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();

        $penjualans = [];

        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        foreach ($months as $key => $month) {
            $penjualans[$key]['month'] = $month;
         
            $array = array_search($month, array_column($pengeluarans, 'month'));
            $penjualans[$key]['pengeluaran'] = $array === false ? 0 : $pengeluarans[$array]['sum'];

            $array2 = array_search($month, array_column($pemasukans, 'month'));
            $penjualans[$key]['pemasukan'] = $array2 === false ? 0 : $pemasukans[$array2]['sum'];

            $penjualans[$key]['profit'] = $penjualans[$key]['pemasukan'] - $penjualans[$key]['pengeluaran'];
           
        }

        $data_pengeluaran = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year, sum(biaya) as sum')
                    ->whereYear('tanggal_pengeluaran',$year)
                    ->groupBy('year')
                    ->value('sum');
   
        $data_pemasukan = Pesanan::selectRaw('year(tanggal_pemesanan) year, sum(total_harga) as sum')
                    ->whereYear('tanggal_pemesanan',$year)
                    ->groupBy('year')
                    ->value('sum');
                    
        $data_penjualan = (int)$data_pemasukan - (int)$data_pengeluaran;

        return view('penjualan.index', compact('years','penjualans', 'data_pengeluaran', 'data_pemasukan', 'data_penjualan'));
    }
    
    public function cetak(){
        $year = Carbon::now()->year;
        $pengeluarans = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year, monthname(tanggal_pengeluaran) month, sum(biaya) as sum')
                    ->whereYear('tanggal_pengeluaran',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();
   
        $pemasukans = Pesanan::selectRaw('year(tanggal_pemesanan) year, monthname(tanggal_pemesanan) month, sum(total_harga) as sum')
                    ->whereYear('tanggal_pemesanan',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();

        $penjualans = [];

        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        foreach ($months as $key => $month) {
            $penjualans[$key]['month'] = $month;
          
            $array = array_search($month, array_column($pengeluarans, 'month'));
            $penjualans[$key]['pengeluaran'] = $array === false ? 0 : $pengeluarans[$array]['sum'];

            $array2 = array_search($month, array_column($pemasukans, 'month'));
            $penjualans[$key]['pemasukan'] = $array2 === false ? 0 : $pemasukans[$array2]['sum'];

            $penjualans[$key]['profit'] = $penjualans[$key]['pemasukan'] - $penjualans[$key]['pengeluaran'];
           
        }

        $data_pengeluaran = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year, sum(biaya) as sum')
                    ->whereYear('tanggal_pengeluaran',$year)
                    ->groupBy('year')
                    ->value('sum');
   
        $data_pemasukan = Pesanan::selectRaw('year(tanggal_pemesanan) year, sum(total_harga) as sum')
                    ->whereYear('tanggal_pemesanan',$year)
                    ->groupBy('year')
                    ->value('sum');
                    
        $data_penjualan = (int)$data_pemasukan - (int)$data_pengeluaran;

        return view('penjualan.cetak', compact('penjualans', 'data_pengeluaran', 'data_pemasukan', 'data_penjualan'));
    }
}
