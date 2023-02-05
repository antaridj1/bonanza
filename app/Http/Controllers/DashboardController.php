<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexOwner(){

        $year = Carbon::now()->year;
        $month = Carbon::now()->format('M');
        $penjualan = Penjualan::selectRaw('sum(total_harga) as sum')->whereYear('created_at',$year)->value('sum');
        $pengeluaran = Pengeluaran::selectRaw('sum(biaya) as sum')->whereYear('created_at',$year)->value('sum');
        $profit = $penjualan - $pengeluaran;
        $stok_kosong = count(Barang::where('stok','0')->get());
        $barang = DetailBarang::selectRaw('sum(jumlah) as sum')->whereYear('created_at',$year)->value('sum');
        return view('dashboard-owner',compact(['penjualan','profit','stok_kosong','barang','year','month']));
    }

    public function indexKaryawan(){
        $year = Carbon::now()->year; 
        
        $id = Auth::id();
        $penjualans = Penjualan::where('karyawans_id',$id)->get();
        $penjualan = Penjualan::where('karyawans_id',$id)->where('status','1')->orderBy('created_at','DESC')->first();
        $belum_proses = $penjualans->where('status','0')->first();
        $jml_belum_proses = count($penjualans->where('status','0'));
        $penjualan_per_tahun = count(Penjualan::where('karyawans_id',$id)->whereYear('created_at',$year)->pluck('id'));
        return view('dashboard-karyawan',compact(['penjualans','penjualan','belum_proses','penjualan_per_tahun','jml_belum_proses']));
    }

    public function getBarangs(Request $request){
        $year = Carbon::now()->year;

        $barangs = Barang::pluck('slug');
        $jumlah = DetailBarang::whereHas('penjualan',function($q){
            $q->where('status',true);
        })
            ->selectRaw('year(created_at) year, barangs_id, sum(jumlah) as sum')
            ->whereYear('created_at',$year)
            ->groupBy('year','barangs_id')
            ->orderBy('barangs_id')
            ->pluck('sum');
        //$jumlah = DetailBarang::orderBy('barangs_id')->groupBy('barangs_id')->selectRaw('sum(jumlah) as sum')->pluck('sum');
        return response()->json(array($barangs,$jumlah));
    }

    public function getProfit(){
        $year = Carbon::now()->year;
        $pengeluarans = Pengeluaran::selectRaw('year(created_at) year, monthname(created_at) month, sum(biaya) as sum')
                    ->whereYear('created_at',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();
    
        $pemasukans = Penjualan::selectRaw('year(created_at) year, monthname(created_at) month, sum(total_harga) as sum')
                    ->where('status',true)
                    ->whereYear('created_at',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();

        $data_pengeluaran = [];
        $data_pemasukan = [];

        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        foreach ($months as $key => $month) {
            $key = array_search($month, array_column($pengeluarans, 'month'));
            $data = $key === false ? 0 : $pengeluarans[$key]['sum'];
            array_push($data_pengeluaran, $data);
        }

        foreach ($months as $key => $month) {
            $key = array_search($month, array_column($pemasukans, 'month'));
            $data = $key === false ? 0 : $pemasukans[$key]['sum'];
            array_push($data_pemasukan, $data);
        }

        $profit = [];

        foreach ($data_pemasukan as $key => $value) {
            if(array_key_exists($key,$data_pemasukan) && array_key_exists($key,$data_pengeluaran)){
                $total = $data_pemasukan[$key]/1000000 - $data_pengeluaran[$key]/1000000;
                $profit[$key] = round($total,2);
            }
        }
        $profits = [];
        array_push($profits,$profit);

        return response()->json($profits);
    }
}
