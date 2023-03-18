<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
class PesananController extends Controller
{
    public function index(Request $request)
    {   
        $years = Pesanan::selectRaw('year(tanggal_pemesanan) year')->groupBy('year')->orderBy('year','DESC')->distinct()->pluck('year');
        $year = $request->year ;
        $date = null;
        if($request->daterange){
            $date = $request->daterange;
            $request['daterange'] = explode(' - ',$request->daterange);
        }
        
        if($request->year){
            $pesanan = Pesanan::whereYear('tanggal_pemesanan',$year)->orderBy('created_at','DESC')->filter(request(['status','search','daterange']));
        } else {
            $pesanan = Pesanan::orderBy('created_at','DESC')->filter(request(['status','search','daterange']));
        }
        
        if(Auth::user()->isOwner == true){
            $pesanans = $pesanan->paginate(10)->withQueryString();
        }else{
            $user_id = Auth::id();
            $pesanans = $pesanan->where('karyawans_id',$user_id)->paginate(10)->withQueryString();
        }

        return view('pesanan.index',compact('pesanans','date','years'));
        
    }

    public function create()
    {   
        $produks = Produk::all();
        return view('pesanan.create',compact('produks'));
    }

    public function getProduk()
    {
        $produks = Produk::all();
        return response()->json($produks);
    }

    public function store(Request $request)
    {
        $reqproduk = collect($request->produk);
        $reqJumlah = collect($request->jumlah);
        $index = count($reqproduk);

        $user_id = Auth::id();

        $request->validate([
            'nama'=> 'required',
            'telp'=>'required',
            'alamat'=>'required',
            'tanggal_pemesanan' => 'required'
        ]);

        $pesanan = Pesanan::create([
            'nama'=> $request->nama,
            'telp'=> $request->telp,
            'alamat'=> $request->alamat,
            'tanggal_pemesanan' => Carbon::parse($request->tanggal_pemesanan),
            'total_harga'=>$request->total_harga,
            'karyawans_id' => $user_id
        ]);

        for($i=0;$i<$index;$i++){

            DetailProduk::create([
                'produks_id' => $reqproduk[$i],
                'pesanans_id' => $pesanan->id,
                'jumlah' => $reqJumlah[$i],
            ]);

            $stok = Produk::where('id',$reqproduk[$i])->value('stok');
            $sisa = $stok - $reqJumlah[$i];
            
            Produk::where('id',$reqproduk[$i])->update([
                'stok' => $sisa
            ]);
        }
        return redirect('pesanan/create')
            ->with('status','success')
            ->with('message','Berhasil menambahkan data');
    }

    public function update(Pesanan $pesanan)
    {   
        if($pesanan->status == 0){
             Pesanan::where('id',$pesanan->id)->update([
                'status' => 2
            ]);
        }
        elseif ($pesanan->status == 2) {
            Pesanan::where('id',$pesanan->id)->update([
                'status' => 1
            ]);
        }
       
        return redirect('pesanan')
            ->with('status','success')
            ->with('message','Berhasil mengedit data');
    }

    public function destroy(Pesanan $pesanan)
    {
        try{
            $pesanan->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus data pesanan');
        }
        return redirect('pesanan')
            ->with('status','success')
            ->with('message','Berhasil menghapus data');
    }

    public function cetak(Request $request){

        if($request->year){
            $pesanans = Pesanan::whereYear('tanggal_pemesanan',$request->year)->orderBy('created_at','DESC')->filter(request(['status','search','daterange']))->get();

            $total = Pesanan::selectRaw('year(tanggal_pemesanan) year, sum(total_harga) as sum')
            ->filter(request(['status','search','daterange']))
            ->whereYear('tanggal_pemesanan',$request->year)
            ->groupBy('year')
            ->value('sum');
        } else {
            $pesanans = Pesanan::orderBy('created_at','DESC')->filter(request(['status','search','daterange']))->get();
             
             $total = Pesanan::selectRaw('sum(total_harga) as sum')
             ->filter(request(['status','search','daterange']))
             ->value('sum');
        }
       
        return view('pesanan.cetak',compact('pesanans','total'));
    }

    public function nota(){
        $pesanan = Pesanan::where('karyawans_id',Auth::id())->orderBy('created_at','DESC')->first();
        return view('pesanan.nota',compact('pesanan'));
    }

    public function cetakNota(){
        $pesanan = Pesanan::where('karyawans_id',Auth::id())->orderBy('created_at','DESC')->first();
        return view('pesanan.cetak-nota',compact('pesanan'));
    }

    public function produkTerjual(){
        $data_produks = Produk::pluck('nama','id');
        $produks = Produk::pluck('nama');
        $data_jumlah = DetailProduk::selectRaw('year(created_at) year, produks_id, sum(jumlah) as sum')
            ->groupBy('year','produks_id')
            ->orderBy('produks_id')
            ->get()->toArray();

            $jumlah = [];

            foreach ($data_produks as $id => $produk) {
                $id = array_search($id, array_column($data_jumlah, 'produks_id'));
                $data = $id === false ? 0 : $data_jumlah[$id]['sum'];
                array_push($jumlah, $data);
            }

        return view('pesanan.produk-terjual', compact('jumlah', 'produks'));
    }
}
