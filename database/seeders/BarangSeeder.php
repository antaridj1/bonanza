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
                'nama'=>'Jati',
                'ukuran'=>'6x12x2',
                'harga_satuan'=>'120000',
                'harga_paket'=>'8000000',
                'jumlah_paket'=>'70',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Jati 6x12x2'
            ],
            [
                'nama'=>'Jati',
                'ukuran'=>'6x15x2',
                'harga_satuan'=>'150000',
                'harga_paket'=>'8000000',
                'jumlah_paket'=>'56',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Jati 6x15x2'
            ],
            [
                'nama'=>'Jati',
                'ukuran'=>'4x12x2',
                'harga_satuan'=>'70000',
                'harga_paket'=>'8000000',
                'jumlah_paket'=>'106',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Jati 4x12x2'
            ],
            [
                'nama'=>'Bayur',
                'ukuran'=>'6x12x2',
                'harga_satuan'=>'90000',
                'harga_paket'=>'5000000',
                'jumlah_paket'=>'70',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Bayur 6x12x2'
            ],
            [
                'nama'=>'Bayur',
                'ukuran'=>'6x15x2',
                'harga_satuan'=>'120000',
                'harga_paket'=>'5000000',
                'jumlah_paket'=>'56',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Bayur 6x15x2'
            ],
            [
                'nama'=>'Bayur',
                'ukuran'=>'4x12x2',
                'harga_satuan'=>'50000',
                'harga_paket'=>'5000000',
                'jumlah_paket'=>'106',
                'stok'=>'1000',
                'keterangan'=>'tes',
                'slug'=>'Bayur 4x12x2',
            ],
            [
                'nama'=>'Ulin',
                'harga_satuan'=>'180000',
                'harga_paket'=>'216000000',
                'jumlah_paket'=>'1200',
                'stok'=>'5000',
                'keterangan'=>'tes',
                'slug'=>'Ulin'
            ]
        ];

        foreach($barangs as $barang){
            Barang::create($barang);
        }
    }
}
