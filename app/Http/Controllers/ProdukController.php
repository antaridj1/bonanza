<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(produk::groupBy('ukuran')->selectRaw('sum(harga_satuan) as sum, ukuran')->pluck('sum','ukuran'));
       // dd(produk::selectRaw('MONTH(created_at) as month')->get());
        $produks = Produk::cari(request(['search']))->paginate(10)->withQueryString();
        return view('produk.index',compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
            $request->validate([
                'nama'=> 'required',
                'harga_satuan'=>'required|numeric|min:1',
                'stok'=>'required|numeric|min:0',
                'keterangan'=>'required'
            ]);

            // $slug = Str::of($request->nama)->append(' ')->append( $request->ukuran);

            Produk::create([
                'nama'=> $request->nama,
                'harga_satuan'=>$request->harga_satuan,
                'stok'=>$request->stok,
                'keterangan'=>$request->keterangan,
                // 'slug'=>$slug,
            ]);

        return redirect('produk')
            ->with('status','success')
            ->with('message','Berhasil menambahkan data');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit',compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    { 
        $edit = $request->validate([
                'nama'=> 'required',
                'harga_satuan'=>'required|numeric|min:1',
                'stok'=>'required|numeric|min:0',
                'keterangan'=>'required'
                ]);
        
        $produk->update([
            'nama'=> $request->nama,
            'harga_satuan'=>$request->harga_satuan,
            'stok'=>$request->stok,
            'keterangan'=>$request->keterangan,
        ]);
        return redirect('produk')
            ->with('status','success')
            ->with('message','Berhasil mengedit data');
    }

    public function destroy(Produk $produk)
    {
        try{
            $produk->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus produk');
        }
        return redirect('produk')
            ->with('status','success')
            ->with('message','Berhasil menghapus data');
    }

    public function getStok(){
        $produks = Produk::all();
        return view('produk.stok',compact('produks'));
    }

    public function postStok(Request $request){
        $request->validate([
            'nama' => 'required',
            'stok' => 'required'
        ]);

        $stok_lama = Produk::where('id',$request->nama)->value('stok');
        $stok_baru = $stok_lama + $request->stok;

        Produk::where('id',$request->nama)->update([
            'stok' => $stok_baru
        ]);

        return redirect('produk')
            ->with('status','success')
            ->with('message','Berhasil menambahkan stok');
    }

    public function cetak(){
        $produks = Produk::all();
        return view('produk.cetak',compact('produks'));
    }
}
