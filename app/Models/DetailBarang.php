<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangs_id',
        'penjualans_id',
        'jumlah',
        'satuan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangs_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualans_id');
    }
}
