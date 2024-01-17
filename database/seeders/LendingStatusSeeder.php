<?php

namespace Database\Seeders;

use App\Models\LendingStatus;
use Illuminate\Database\Seeder;

class LendingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lendingStatuses = [
            ['id' => 1, 'name' => 'Baru'],
            ['id' => 2, 'name' => 'Diproses'],
            ['id' => 3, 'name' => 'Diterima'],
            ['id' => 4, 'name' => 'Ditolak']
        ];

        foreach ($lendingStatuses as $lendingStatus) {
            LendingStatus::withTrashed()->updateOrCreate(
                ['id' => $lendingStatus['id']],
                ['name' => $lendingStatus['name']]
            );
        }
    }
}
