<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['id' => 1, 'name' => 'Administrator'],
            ['id' => 10, 'name' => 'Atlet'],
            ['id' => 20, 'name' => 'Pelatih'],
            ['id' => 30, 'name' => 'Wasit'],
            ['id' => 90, 'name' => 'Umum']
        ];

        foreach ($datas as $key => $value) {
            Role::withTrashed()->updateOrCreate(
                [
                    'id' => $value['id'],
                ],
                [
                    'name' => $value['name'],
                    'deleted_at' => null
                ]
            );
        }
    }
}
