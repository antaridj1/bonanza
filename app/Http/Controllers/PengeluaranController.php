<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Exception;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $years = Pengeluaran::selectRaw('year(tanggal_pengeluaran) year')->groupBy('year')->orderBy('year','DESC')->distinct()->pluck('year');
        $year = $request->year;
        if($request->year){
            $pengeluarans = Pengeluaran::whereYear('tanggal_pengeluaran', $year)->orderBy('created_at','DESC')->cari(request(['search']))->paginate(10)->withQueryString();
        } else {
             $pengeluarans = Pengeluaran::orderBy('created_at','DESC')->cari(request(['search']))->paginate(10)->withQueryString();
        }
       
        return view('pengeluaran.index',compact('pengeluarans','years'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama'=> 'required',
                'biaya'=>'required|numeric|min:1',
                'tanggal_pengeluaran' => 'required'
            ]);

            Pengeluaran::create($request->all());

        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan pengeluaran');
        }
        return redirect('pengeluaran')
            ->with('status','success')
            ->with('message','Berhasil menambahkan data');
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        try{
            $request->validate([
                'nama'=> 'required',
                'biaya'=>'required|numeric|min:1',
                'tanggal_pengeluaran' => 'required'
            ]);

            $test = $pengeluaran->update($request->all());
            
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal mengedit pengeluaran');
        }
        return redirect('pengeluaran')
            ->with('status','success')
            ->with('message','Berhasil mengedit data');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        try{
            $pengeluaran->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus pengeluaran');
        }
        return redirect('pengeluaran')
            ->with('status','success')
            ->with('message','Berhasil menghapus data');
    }

    public function cetak(){
        $pengeluarans = Pengeluaran::all();
        return view('pengeluaran.cetak',compact('pengeluarans'));
    }
}
