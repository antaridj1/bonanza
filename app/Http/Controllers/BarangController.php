<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Barang::groupBy('ukuran')->selectRaw('sum(harga_satuan) as sum, ukuran')->pluck('sum','ukuran'));
       // dd(Barang::selectRaw('MONTH(created_at) as month')->get());
        $barangs = Barang::cari(request(['search']))->paginate(10)->withQueryString();
        return view('barang.index',compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        if (!$request->ukuran)
        {
            $request->validate([
                'nama'=> 'required',
                'harga_satuan'=>'required|numeric|min:1',
                'harga_paket'=>'required|numeric|min:1',
                'jumlah_paket'=>'required|numeric|min:1',
                'stok'=>'required|numeric|min:0',
                'keterangan'=>'required'
            ]);

            $slug = Str::of($request->nama)->append(' ')->append( $request->ukuran);
            // $slug = Str::slug($text, '-');

            Barang::create([
                'nama'=> $request->nama,
                'harga_satuan'=>$request->harga_satuan,
                'harga_paket'=>$request->harga_paket,
                'jumlah_paket'=>$request->jumlah_paket,
                'stok'=>$request->stok,
                'keterangan'=>$request->keterangan,
                'slug'=>$slug,
            ]);
        }
        else
        {
            $request->validate([
                'nama'=> 'required',
                'ukuran'=>'required',
                'harga_satuan'=>'required|numeric|min:1',
                'harga_paket'=>'required|numeric|min:1',
                'jumlah_paket'=>'required|numeric|min:1',
                'stok'=>'required|numeric|min:0',
                'keterangan'=>'required'
            ]);

            $slug = Str::of($request->nama)->append(' ')->append( $request->ukuran);
            // $slug = Str::slug($text, '-');

            Barang::create([
                'nama'=> $request->nama,
                'ukuran'=>$request->ukuran,
                'harga_satuan'=>$request->harga_satuan,
                'harga_paket'=>$request->harga_paket,
                'jumlah_paket'=>$request->jumlah_paket,
                'stok'=>$request->stok,
                'keterangan'=>$request->keterangan,
                'slug'=>$slug,
            ]);
        }
        return redirect('barang')
            ->with('status','success')
            ->with('message','Berhasil menambahkan data');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit',compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    { 
        $slug = Str::of($request->nama)->append(' ')->append( $request->ukuran);

        if (!$request->ukuran)
        {
            $edit = $request->validate([
                    'nama'=> 'required',
                    'harga_satuan'=>'required|numeric|min:1',
                    'harga_paket'=>'required|numeric|min:1',
                    'jumlah_paket'=>'required|numeric|min:1',
                    'stok'=>'required|numeric|min:0',
                    'keterangan'=>'required'
                    ]);
        }
        else
        {
            $edit = $request->validate([
                'nama'=> 'required',
                'ukuran' => 'required',
                'harga_satuan'=>'required|numeric|min:1',
                'harga_paket'=>'required|numeric|min:1',
                'jumlah_paket'=>'required|numeric|min:1',
                'stok'=>'required|numeric|min:0',
                'keterangan'=>'required'
                ]); 
        }
        $barang->update([
            'nama'=> $request->nama,
            'ukuran' => $request->ukuran,
            'harga_satuan'=>$request->harga_satuan,
            'harga_paket'=>$request->harga_paket,
            'jumlah_paket'=>$request->jumlah_paket,
            'stok'=>$request->stok,
            'keterangan'=>$request->keterangan,
            'slug'=>$slug
        ]);
        return redirect('barang')
            ->with('status','success')
            ->with('message','Berhasil mengedit data');
    }

    public function destroy(Barang $barang)
    {
        try{
            $barang->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus barang');
        }
        return redirect('barang')
            ->with('status','success')
            ->with('message','Berhasil menghapus data');
    }

    public function getStok(){
        $barangs = Barang::all();
        return view('barang.stok',compact('barangs'));
    }

    public function postStok(Request $request){
        $request->validate([
            'nama' => 'required',
            'stok' => 'required'
        ]);

        $stok_lama = Barang::where('id',$request->nama)->value('stok');
        $stok_baru = $stok_lama + $request->stok;

        Barang::where('id',$request->nama)->update([
            'stok' => $stok_baru
        ]);

        return redirect('barang')
            ->with('status','success')
            ->with('message','Berhasil menambahkan stok');
    }

    public function cetak(){
        $barangs = Barang::all();
        return view('barang.cetak',compact('barangs'));
    }
}
