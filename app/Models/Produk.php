<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga_satuan',
        'stok',
        'keterangan',
    ];
    // protected $guarded = 'id';

    public function detail_produk()
    {
        return $this->hasMany(DetailProduk::class, 'produks_id');
    }

    public function scopeCari($query, array $cari){
        $query->when($cari['search'] ?? false, function($query, $search) {
            return $query->where('nama','like','%'.$search.'%')
                        ->orWhere('harga_satuan','like','%'.$search.'%');
        });
    }
}
