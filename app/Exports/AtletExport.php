<?php

namespace App\Exports;

use App\Models\Atlet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AtletExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('atlets')
        ->select('cabors.name as cabor','atlets.nik','atlets.name','atlets.birth_place','atlets.birth_date', 'atlets.address','atlets.phone', 'ver.name as verif')
        ->leftJoin('cabors', 'atlets.cabor_id', '=', 'cabors.id')
        ->leftJoin('verification_statuses as ver', 'atlets.status_id', '=', 'ver.id')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Cabor',
            'Nik',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Telpon',
            'Status',
        ];
    }
}
