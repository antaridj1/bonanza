<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
class UserController extends Controller
{
    public function index()
    {
        $karyawans = User::where('isOwner',false)->cari(request(['search']))->paginate(10)->withQueryString();
        return view('karyawan.index',compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nama'=> 'required',
                'telp'=>'required',
                'alamat'=>'required',
                'username'=>'required',
                'password'=>'required',
            ]);
    
            User::create([
                'nama'=>$request->nama,
                'telp'=>$request->telp,
                'alamat'=>$request->alamat,
                'username'=>$request->username,
                'password'=>bcrypt($request->password)
            ]);

        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()
                ->with('status','error')
                ->with('message','Gagal menambahkan karyawan');
        }
        return redirect('karyawan')
            ->with('status','success')
            ->with('message','Berhasil menambahkan karyawan');
    }

    public function edit(User $karyawan)
    {
        return view('karyawan.edit',compact('karyawan'));
    }

    public function update(Request $request, User $user)
    {
        try{
            $request->validate([
                'nama'=> 'required',
                'telp'=>'required',
                'username'=>'required',
                'alamat'=>'required',
            ]);

            $user->update($request->all());

        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal mengedit user');
        }
        return redirect()->back()
            ->with('status','success')
            ->with('message','Data telah diubah');
    }

    public function updateStatus(Request $request, User $user)
    {
        if($user->status == true){
            $user->update(['status'=>false]);
        }else{
            $user->update(['status'=>true]);
        }
        return redirect()->back()
            ->with('status','success')
            ->with('message','Status telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
        }catch(Exception $e){
            Log::info($e->getMessage());
            return back()->withInput()->with('error', 'Gagal menghapus data karyawan');
        }
        return redirect('karyawan')
            ->with('status','success')
            ->with('message','Berhasil menghapus karyawan');
    }

    public function profil(){
        $user_id = Auth::id();
        $users = User::where('id',$user_id)->get();
        return view('profil',compact('users'));
    }

    public function updatePass(Request $request){
        $user_id = Auth::id();
        $password = User::where('id',$user_id)->value('password');

        $request->validate([
            'password_baru'=>'required|min:3|max:255',
            'password_lama'=>'required|min:3|max:255',
            'konfirmasi'=>'required||min:3|max:255',
        ]);
        
        if(password_verify($request->password_lama, $password) && 
        $request->password_baru == $request->konfirmasi){
            User::where('id',$user_id)->update([
                'password'=>bcrypt($request->password_baru)
            ]);
        }else{
            return redirect()->back()
            ->with('status','error')
            ->with('message','Password gagal diubah');
        }
        return redirect()->back()
            ->with('status','success')
            ->with('message','Password berhasil diubah');
    }
}
