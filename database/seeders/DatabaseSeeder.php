<?php

namespace Database\Seeders;

use App\Models\LendingStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CaborSeeder::class);
        $this->call(LendingStatusSeeder::class);
        $this->call(NumberSettingSeeder::class);
        $this->call(VerificationStatusSeeder::class);
    }
}
