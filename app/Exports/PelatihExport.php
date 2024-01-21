<?php

namespace App\Exports;

use App\Models\Pelatih;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelatihExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('pelatih')
        ->select('cabors.name as cabor','pelatih.nik','pelatih.name','pelatih.birth_place','pelatih.birth_date', 'pelatih.address','pelatih.phone', 'ver.name as verif')
        ->leftJoin('cabors', 'pelatih.cabor_id', '=', 'cabors.id')
        ->leftJoin('verification_statuses as ver', 'pelatih.status_id', '=', 'ver.id')
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
