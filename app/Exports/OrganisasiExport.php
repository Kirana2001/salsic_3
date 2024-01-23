<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrganisasiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('pemudas')
        ->select('users.username','organization_name','bidangs.name as bname','ver.name as vname','founder','leader','secretary','treasurer','pemudas.phone','address','description','male_member','female_member','pemudas.created_at')
        ->leftJoin('users', 'user_id','=','users.id')
        ->leftJoin('bidangs','bidang_id','=','bidangs.id')
        ->leftJoin('verification_statuses as ver', 'pemudas.status_id', '=', 'ver.id')
        ->where('pemudas.deleted_at','=',null)
        ->get();
    }

    public function headings(): array
    {
        return [
            'Username',
            'Organisasi',
            'Bidang',
            'Status',
            'Pendiri',
            'Ketua',
            'Sekretaris',
            'Bendahara',
            'Telpon',
            'Alamat',
            'Deskripsi',
            'Anggota Pria',
            'Anggota Wanita',
            'Total Anggota',
            'Tanggal Daftar',
        ];
    }
}
