<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produks_id',
        'penjualans_id',
        'jumlah',
    ];

    public function produk()
    {
        return $this->belongsTo(produk::class, 'produks_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualans_id');
    }
}
