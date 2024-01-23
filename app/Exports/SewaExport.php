<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SewaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
        public function collection()
    {
        return DB::table('arena_lendings')
        ->select('users.username','number','application_date','arena_lendings.name as lname','arena_lendings.nik','arena_lendings.phone','arena_lendings.email','arena_lendings.address','start_date','end_date','start_time','end_time','jenis_kegiatan','nama_kegiatan','purpose','arenas.name as aname','ver.name as vname')
        ->leftJoin('users', 'user_id','=','users.id')
        ->leftJoin('arenas', 'arena_id','=','arenas.id')
        ->leftJoin('verification_statuses as ver', 'arena_lendings.status_id', '=', 'ver.id')
        ->where('arena_lendings.deleted_at','=',null)
        ->get();
    }

    public function headings(): array
    {
        return [
            'Username',
            'Nomor',
            'Tanggal pengajuan',
            'Nama',
            'NIK',
            'Telpon',
            'Email',
            'Alamat',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jam Mulai',
            'Jam Selesai',
            'Jenis Kegiatan',
            'Nama Kegiatan',
            'Tujuan Kegiatan',
            'Arena',
            'Status',
        ];
    }
}
