<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'name' => 'Admin',
                'username' => 'administrator',
                'password' => bcrypt('salsic2023'),
                'email' => 'admin@mail.com',
                'phone' => '12345',
                'role_id' => 1
            ]
        );
    }
}
