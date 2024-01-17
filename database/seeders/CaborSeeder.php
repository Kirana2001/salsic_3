<?php

namespace Database\Seeders;

use App\Models\Cabor;
use Illuminate\Database\Seeder;

class CaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["id" => 1, "name" => "Anggar"],
            ["id" => 2, "name" => "Angkat Besi"],
            ["id" => 3, "name" => "Atletik"],
            ["id" => 4, "name" => "Biliar"],
            ["id" => 5, "name" => "Bola Basket"],
            ["id" => 6, "name" => "Bridge"],
            ["id" => 7, "name" => "Bulu Tangkis"],
            ["id" => 8, "name" => "Catur"],
            ["id" => 9, "name" => "Hoki Lapangan"],
            ["id" => 10, "name" => "Karate"],
            ["id" => 11, "name" => "Panahan"],
            ["id" => 12, "name" => "Panjat Tebing"],
            ["id" => 13, "name" => "Pacuan Kuda"],
            ["id" => 14, "name" => "Perahu Layar"],
            ["id" => 15, "name" => "Polo Air"],
            ["id" => 16, "name" => "Renang"],
            ["id" => 17, "name" => "Senam"],
            ["id" => 18, "name" => "Sepak Futsal"],
            ["id" => 19, "name" => "Sepak Bola"],
            ["id" => 20, "name" => "Sepak Takraw"],
            ["id" => 21, "name" => "Sepatu Roda"],
            ["id" => 22, "name" => "Taekwondo"],
            ["id" => 23, "name" => "Tenis Meja"],
            ["id" => 24, "name" => "Tinju"],
            ["id" => 25, "name" => "Triathlon"],
            ["id" => 26, "name" => "Voli"],
        ];

        foreach ($datas as $data) {
            Cabor::withTrashed()->updateOrCreate(
                ["id" => $data['id']],
                [
                    "name" => $data['name'],
                    "deleted_at" => null
                ]
            );
        }
    }
}
