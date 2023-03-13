<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\DetailProduk;
use App\Models\Pengeluaran;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexOwner(){

        $year = Carbon::now()->year;
        $month = Carbon::now()->format('M');
        $pesanan = Pesanan::selectRaw('sum(total_harga) as sum')->where('status',1)->whereYear('created_at',$year)->value('sum');
        $pengeluaran = Pengeluaran::selectRaw('sum(biaya) as sum')->whereYear('created_at',$year)->value('sum');
        $profit = $pesanan - $pengeluaran;
        $stok_kosong = count(Produk::where('stok','0')->get());
        $produk = DetailProduk::selectRaw('sum(jumlah) as sum')->whereYear('created_at',$year)->value('sum');
        return view('dashboard-owner',compact(['pesanan','profit','stok_kosong','produk','year','month', 'pengeluaran']));
    }

    public function indexKaryawan(){
        $year = Carbon::now()->year; 
        $id = Auth::id();
        $stok_kosong = count(Produk::where('stok','0')->get());
        $pesanans = Pesanan::where('karyawans_id',$id)->get();
        $pesanan = Pesanan::where('karyawans_id',$id)->orderBy('created_at','DESC')->first();
        $pesanan_per_tahun = count(Pesanan::where('karyawans_id',$id)->whereYear('created_at',$year)->pluck('id'));
        return view('dashboard-karyawan',compact(['pesanans','pesanan','pesanan_per_tahun','stok_kosong']));
    }

    public function getProduks(Request $request){
        $year = Carbon::now()->year;

        $data_produks = Produk::pluck('nama','id');
        $produks = Produk::pluck('nama');
        $data_jumlah = DetailProduk::selectRaw('year(created_at) year, produks_id, sum(jumlah) as sum')
            ->whereYear('created_at',$year)
            ->groupBy('year','produks_id')
            ->orderBy('produks_id')
            ->get()->toArray();

            $jumlah = [];

            foreach ($data_produks as $id => $produk) {
                $id = array_search($id, array_column($data_jumlah, 'produks_id'));
                $data = $id === false ? 0 : $data_jumlah[$id]['sum'];
                array_push($jumlah, $data);
            }

           
            // dd($jumlah);
        //$jumlah = Detailproduk::orderBy('produks_id')->groupBy('produks_id')->selectRaw('sum(jumlah) as sum')->pluck('sum');
        return response()->json(array($produks,$jumlah));
    }

    public function getProfit(){
        $year = Carbon::now()->year;
        $pengeluarans = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year, monthname(tanggal_pengeluaran) month, sum(biaya) as sum')
                    ->whereYear('tanggal_pengeluaran',$year)
                    ->groupBy('year','month')
                    ->orderBy('month','DESC')
                    ->get()->toArray();
    
        $pemasukans = Pesanan::selectRaw('year(tanggal_pemesanan) year, monthname(tanggal_pemesanan) month, sum(total_harga) as sum')
                    ->whereYear('tanggal_pemesanan',$year)
                    ->where('status',1)
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
