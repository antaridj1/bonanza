<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pesanans = 
        [
            [
                'nama'=>'Putri Pramesti',
                'telp'=>'0876789876',
                'total_harga'=>'120000',
                'alamat'=>'Jalan Imam Bonjol Gang Segina no 1',
                'karyawans_id'=>'1',
                'status'=>'0',
            ],
            [
                'nama'=>'Wahyu Ady',
                'telp'=>'0876789877',
                'total_harga'=>'780000',
                'alamat'=>'Jalan Imam Bonjol Gang Segina no 2',
                'karyawans_id'=>'1',
                'status'=>'1',
            ],
            
        ];

        foreach($pesanans as $pesanan){
            Pesanan::create($pesanan);
        }
    }
}
