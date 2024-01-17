<?php

namespace Database\Seeders;

use App\Models\VerificationStatus;
use Illuminate\Database\Seeder;

class VerificationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['id' => 1, 'name' => 'Baru'],
            ['id' => 2, 'name' => 'Proses Verifikasi'],
            ['id' => 3, 'name' => 'Terverifikasi'],
            ['id' => 4, 'name' => 'Ditolak'],
            ['id' => 5, 'name' => 'Selesai']
        ];

        foreach ($datas as $data) {
            VerificationStatus::withTrashed()->updateOrCreate(
                ['id' => $data['id']],
                ['name' => $data['name']],
            );
        }
    }
}
