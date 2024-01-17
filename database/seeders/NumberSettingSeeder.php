<?php

namespace Database\Seeders;

use App\Models\NumberSetting;
use Illuminate\Database\Seeder;

class NumberSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NumberSetting::updateOrCreate(
            ['id' => 1],
            [
                'no_arena_lending' => 0,
            ]
        );
    }
}
