<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExport;
use App\Exports\ArenaExport;
use Illuminate\Http\Request;
use App\Exports\AtletExport;
use App\Exports\OrganisasiExport;
use App\Exports\PelatihExport;
use App\Exports\SewaExport;
use App\Exports\WasitExport;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function atletExport() 
    {
        return Excel::download(new AtletExport, 'atlet.xlsx');
    }

    public function pelatihExport() 
    {
        return Excel::download(new PelatihExport, 'pelatih.xlsx');
    }

    public function wasitExport() 
    {
        return Excel::download(new WasitExport, 'wasit.xlsx');
    }

    public function organisasiExport() 
    {
        return Excel::download(new OrganisasiExport, 'organisasi.xlsx');
    }

    public function anggotaExport() 
    {
        return Excel::download(new AnggotaExport, 'anggota.xlsx');
    }

    public function arenaExport() 
    {
        return Excel::download(new ArenaExport, 'arena.xlsx');
    }

    public function sewaExport() 
    {
        return Excel::download(new SewaExport, 'sewa.xlsx');
    }
}
