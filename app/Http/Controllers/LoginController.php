<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Arena;
use App\Models\ArenaLending;
use App\Models\Atlet;
use App\Models\Pelatih;
use App\Models\Pemuda;
use App\Models\Wasit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginView()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            return redirect('/dashboard');
        }

        return redirect('/login')->with('error', 'Invalid Username or Password');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
        }

        return redirect('/login');
    }

    public function dashboard()
    {
        $data['arena'] = Arena::all()->count();
        $pemuda = Pemuda::where('status_id', 3);
        $data['pemuda'] = $pemuda->count();
        $data['pemuda_pria'] = $pemuda->sum('male_member');
        $data['pemuda_wanita'] = $pemuda->sum('female_member');

        $data['sewa'] = ArenaLending::all()->count();

        $data['anggota_all'] = Anggota::all()->count();
        $data['pria'] = Anggota::where('gender', 'pria')->count();
        $data['wanita'] = Anggota::where('gender', 'wanita')->count();
        
        $atlet = Atlet::where('status_id', 3)->get();
        $data['atlet'] = $atlet->count();
        $data['atlet_pria'] = $atlet->where('gender', 'pria')->count();
        $data['atlet_wanita'] = $atlet->where('gender', 'wanita')->count();

        $pelatih =  Pelatih::where('status_id', 3)->get();
        $data['pelatih'] = $pelatih->count();
        $data['pelatih_pria'] = $pelatih->where('gender', 'pria')->count();
        $data['pelatih_wanita'] = $pelatih->where('gender', 'wanita')->count();

        $wasit = Wasit::where('status_id', 3)->get();
        $data['wasit'] = $wasit->count();
        $data['wasit_pria'] = $wasit->where('gender', 'pria')->count();
        $data['wasit_wanita'] = $wasit->where('gender', 'wanita')->count();
        
        return view('dashboard', $data);
    }
}
