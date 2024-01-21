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
        $data['sewa'] = ArenaLending::all()->count();
        $data['pria'] = Anggota::whereHas('pemuda')->where('gender', 'pria')->count();
        $data['wanita'] = Anggota::whereHas('pemuda')->where('gender', 'wanita')->count();
        $data['total'] = $data['pria'] + $data['wanita'];
        $data['atlet'] = Atlet::where('status_id', 3)->get()->count();
        $data['pelatih'] = Pelatih::where('status_id', 3)->get()->count();
        $data['wasit'] = Wasit::where('status_id', 3)->get()->count();
        return view('dashboard', $data);
    }
}
