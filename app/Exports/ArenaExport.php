<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArenaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('arenas')
        ->select('name','ownership','address','facilities','longitude','latitude','created_at')
        ->where('pemudas.deleted_at','=',null)
        ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Pemilik',
            'Alamat',
            'Fasilitas',
            'Longitude',
            'Latitude',
            'Tanggal Daftar',
        ];
    }
}
