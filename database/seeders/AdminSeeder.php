<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        $adminRecords = [
            ['id' => 1, 'name' => 'John', 'type'=> 'admin', 'phone'=> '8162696846', 'email'=> 'admin@gmail.com', 'image'=> 'admin-image', 'status'=> 1, 'password' => $password ],
            ['id' => 2, 'name' => 'Amanda', 'type'=> 'admin', 'phone'=> '8162696848', 'email'=> 'admin2@gmail.com', 'image'=> 'admin-image', 'status'=> 1, 'password' => $password],
            ['id' => 3, 'name' => 'Mary', 'type'=> 'admin', 'phone'=> '8162696842', 'email'=> 'admin3@gmail.com', 'image'=> 'admin-image', 'status'=> 1, 'password' => $password]
        ];

        Admin::insert($adminRecords);
    }
}
