<?php

namespace App\Exports;

use App\Models\Wasit;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WasitExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('wasit')
        ->select('cabors.name as cabor','wasit.nik','wasit.name','wasit.birth_place','wasit.birth_date', 'wasit.address','wasit.phone', 'ver.name as verif')
        ->leftJoin('cabors', 'wasit.cabor_id', '=', 'cabors.id')
        ->leftJoin('verification_statuses as ver', 'wasit.status_id', '=', 'ver.id')
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
