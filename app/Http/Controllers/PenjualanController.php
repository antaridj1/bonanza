<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\DetailBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
class PenjualanController extends Controller
{
    public function index(Request $request)
    {   
        $date = null;
        if($request->daterange){
            $date = $request->daterange;
            $request['daterange'] = explode(' - ',$request->daterange);
        }
        if(Auth::user()->isOwner == true){
            $penjualans = Penjualan::orderBy('created_at','DESC')->filter(request(['status','search','daterange']))->paginate(10)->withQueryString();
        }else{
            $user_id = Auth::id();
            $penjualans = Penjualan::orderBy('created_at','DESC')->where('karyawans_id',$user_id)->filter(request(['status','search','daterange']))->paginate(10)->withQueryString();
        }

        return view('penjualan.index',compact(['penjualans','date']));
        
    }

    public function create()
    {   
        $barangs = Barang::all();
        return view('penjualan.create',compact('barangs'));
    }

    public function getBarang()
    {
        $barangs = Barang::all();
        return response()->json($barangs);
    }

    public function store(Request $request)
    {
        $reqBarang = collect($request->barang);
        $reqJumlah = collect($request->jumlah);
        $reqSatuan = collect($request->satuan);
        $index = count($reqBarang);

        $user_id = Auth::id();

        $request->validate([
            'nama'=> 'required',
            'telp'=>'required',
            'alamat'=>'required',
        ]);

        $penjualan = Penjualan::create([
            'nama'=> $request->nama,
            'telp'=> $request->telp,
            'alamat'=> $request->alamat,
            'total_harga'=>$request->total_harga,
            'karyawans_id' => $user_id
        ]);

        for($i=0;$i<$index;$i++){
            if ($reqSatuan[$i] == "Paket"){
                $jml_paket = Barang::where('id',$reqBarang[$i])->value('jumlah_paket');
                $reqJumlah[$i] = $reqJumlah[$i] * $jml_paket;
            }
            DetailBarang::create([
                'barangs_id' => $reqBarang[$i],
                'penjualans_id' => $penjualan->id,
                'jumlah' => $reqJumlah[$i],
                'satuan' => $reqSatuan[$i],
            ]);

            $stok = Barang::where('id',$reqBarang[$i])->value('stok');
            $sisa = $stok - $reqJumlah[$i];
            
            Barang::where('id',$reqBarang[$i])->update([
                'stok' => $sisa
            ]);
        }
        return redirect('penjualan/nota')
            ->with('status','success')
            ->with('message','Berhasil menambahkan data');
    }

    public function update(Penjualan $penjualan)
    {
        Penjualan::where('id',$penjualan->id)->update([
            'status' => 1
        ]);
        return redirect('penjualan')
            ->with('status','success')
            ->with('message','Berhasil mengedit data');
    }

    public function destroy(Penjualan $penjualan)
    {
        try{
            $penjualan->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus data penjualan');
        }
        return redirect('penjualan')
            ->with('status','success')
            ->with('message','Berhasil menghapus data');
    }

    public function cetak(){
        $penjualans = Penjualan::all();
        return view('penjualan.cetak',compact('penjualans'));
    }

    public function nota(){
        $penjualan = Penjualan::where('karyawans_id',Auth::id())->orderBy('created_at','DESC')->first();
        return view('penjualan.nota',compact('penjualan'));
    }

    public function cetakNota(){
        $penjualan = Penjualan::where('karyawans_id',Auth::id())->orderBy('created_at','DESC')->first();
        return view('penjualan.cetak-nota',compact('penjualan'));
    }
}
