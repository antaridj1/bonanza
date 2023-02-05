<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'telp',
        'alamat',
        'total_harga',
        'karyawans_id',
        'status'
    ];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawans_id');
    }

    public function detail_barang()
    {
        return $this->hasMany(DetailBarang::class, 'penjualans_id');
    }

    public function scopeFilter($query, array $filter){
        // dd($filter['daterange']);
        $query->when($filter['search'] ?? false, function($query, $search) {
            return $query->where('nama','like','%'.$search.'%')
                        ->orWhere('alamat','like','%'.$search.'%')
                        ->orWhere('telp','like','%'.$search.'%')
                        ->orWhere('created_at','like','%'.$search.'%')
                        ->orWhereHas('karyawan', function($q) use($search){
                            $q->where('nama','like','%'.$search.'%');
                        });          
        });

        $query->when($filter['status'] ?? false, function($query, $status){
            return $query->where('status',$status);
        });

        $query->when($filter['daterange'] ?? false, function($query, $daterange) {
            return $query->WhereBetween('created_at',[Carbon::parse($daterange[0])->format('Y-m-d'),Carbon::parse($daterange[1])->format('Y-m-d')]);          
        });
    }
}
