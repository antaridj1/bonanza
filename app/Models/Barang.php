<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'ukuran',
        'harga_satuan',
        'harga_paket',
        'jumlah_paket',
        'stok',
        'keterangan',
        'slug'
    ];
    // protected $guarded = 'id';

    public function detail_barang()
    {
        return $this->hasMany(DetailBarang::class, 'barangs_id');
    }

    public function scopeCari($query, array $cari){
        $query->when($cari['search'] ?? false, function($query, $search) {
            return $query->where('nama','like','%'.$search.'%')
                        ->orWhere('ukuran','like','%'.$search.'%')
                        ->orWhere('harga_satuan','like','%'.$search.'%')
                        ->orWhere('harga_paket','like','%'.$search.'%')
                        ->orWhere('jumlah_paket','like','%'.$search.'%');
        });
    }
}
