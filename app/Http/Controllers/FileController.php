<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AtletExport;
use App\Exports\PelatihExport;
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
}
