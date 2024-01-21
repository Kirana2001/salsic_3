<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pemuda;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('anggotas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['pemudas'] = Pemuda::all();
        return view('anggotas.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'pemuda_id' => 'required',
            'gender' => 'required',
            'nik' => 'required',
            'alamat_ktp' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_domisili' => 'required',
            'pekerjaan' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'telp' => 'required',
            'email' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        $userData['name'] = $data['name'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['telp'];
        $userData['role_id'] = 41;

        if (User::where('username', $userData['username'])->count() > 0) {
            return redirect()->back()->with('error', 'Username (NIK) sudah digunakan');
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return redirect()->back()->with('error', 'Data wasit gagal disimpan');
        }
        $data['user_id'] = $newUser->id;

        $ok = Anggota::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data anggota gagal disimpan');
        }

        return redirect('/anggotas')->with('success', 'Data anggota berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['anggotas'] = Anggota::find($id);
        $datas['pemudas'] = Pemuda::all();
        return view('anggotas.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['anggotas'] = Anggota::find($id);
        $datas['pemudas'] = Pemuda::all();
        return view('anggotas.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'pemuda_id' => 'required',
            'gender' => 'required',
            'nik' => 'required',
            'alamat_ktp' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_domisili' => 'required',
            'pekerjaan' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'telp' => 'required',
            'email' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        $ok = Anggota::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data anggota gagal disimpan');
        }

        return redirect('/anggotas')->with('success', 'Data anggota berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Anggota::find($id)->delete();

        if(!$ok) {
            return redirect()->back()->with('error', 'Anggota gagal dihapus');
        }

        return redirect()->back()->with('success', 'Anggota berhasil dihapus');
    }

    public function anggotaDatatable()
    {
        $anggotas = Anggota::with('pemuda')->orderBy('id', 'desc')->get();
        return datatables()->of($anggotas)->addIndexColumn()->toJson();
    }
}
