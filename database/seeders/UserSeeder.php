<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nama' => 'Pemilik',
                'username' => 'pemilik123',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'isOwner'=>true,
                'status'=>true,
            ],
            [
                'nama' => 'Admin 1',
                'username' => 'admin123',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.2',
                'telp'=>'089678678677',
                'isOwner'=>false,
                'status'=>true,
            ],
            [
                'nama' => 'Admin 2',
                'username' => 'adminn123',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.2',
                'telp'=>'089678678677',
                'isOwner'=>false,
                'status'=>true,
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
