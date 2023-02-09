<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barangs = 
        [
           [
            'nama' => 'Baby Tuna',
            'harga_satuan' => 310000,
            'stok' => 100,
            'keterangan' => 'minimal pembelian 10kg',
           ],
           [
            'nama' => 'Cakalan',
            'harga_satuan' => 300000,
            'stok' => 100,
            'keterangan' => 'minimal pembelian 10kg',
           ],
           [
            'nama' => 'Tongkol',
            'harga_satuan' => 285000,
            'stok' => 100,
            'keterangan' => 'minimal pembelian 10kg',
           ],
           [
            'nama' => 'Selungsung',
            'harga_satuan' => 295000,
            'stok' => 100,
            'keterangan' => 'minimal pembelian 10kg',
           ]
        ];

        foreach($barangs as $barang){
            Barang::create($barang);
        }
    }
}
