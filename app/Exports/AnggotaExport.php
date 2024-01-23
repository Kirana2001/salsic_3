<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggotaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('anggotas')
        ->select('users.username','ver.name as vname','anggotas.name as lname','organisasi','gender','nik','tgl_lahir','tmp_lahir','alamat_ktp','alamat_domisili','kecamatan','kelurahan','pekerjaan','phone','anggotas.email','anggotas.instagram','anggotas.youtube','anggotas.twitter','anggotas.facebook')
        ->leftJoin('users', 'user_id','=','users.id')
        ->leftJoin('verification_statuses as ver', 'anggotas.status_id', '=', 'ver.id')
        ->where('anggotas.deleted_at','=',null)
        ->get();
    }

    public function headings(): array
    {
        return [
            'Username',
            'Status',
            'Nama',
            'Organisasi',
            'Gender',
            'NIK',
            'Tanggal Lahir',
            'Tempat Lahir',
            'Alamat KTP',
            'Alamat Domisili',
            'Kecamatan',
            'Kelurahan',
            'Pekerjaan',
            'Telpon',
            'Email',
            'Instagram',
            'Youtube',
            'Twitter',
            'Facebook'
        ];
    }
}
