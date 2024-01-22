<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Pemuda;
use App\Models\User;
use App\Models\VerificationStatus;
use Illuminate\Support\Facades\Auth;

class ApiAnggotaController extends Controller
{
    public function index()
    {
        $datas = Anggota::where('user_id', Auth::user()->id)->get();

        foreach ($datas as $data) {
            $data->pemuda = Pemuda::find($data->pemuda_id)->organization_name;
            $data->status = VerificationStatus::find($data->status_id)->name;
        }

        $datas->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at', 'pemuda_id']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $datas,
        ]);
    }

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
            return response()->json([
                'code' => 400,
                'message' => 'Username sudah dipakai',
            ], 400);
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return response()->json([
                'code' => 400,
                'message' => 'Gagal membuat User',
            ], 400);
        }
        $data['user_id'] = $newUser->id;
        $data['status_id'] = 1;

        $ok = Anggota::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Gagal membuat data Anggota',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Pendaftaran Anggota Success',
        ]);
    }

    public function show(Request $request)
    {
        $data = Anggota::where('user_id', 23)->find($request->id);
        $data->pemuda = Pemuda::find($data->pemuda_id)->organization_name;
        $data->status = VerificationStatus::find($data->status_id)->name;
        $data->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at', 'pemuda_id']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ]);
    }

    public function update(Request $request)
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

        $ok = Anggota::find($request->id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'error',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Perubahan Data Pendaftaran Anggota Success',
        ]);
    }
}
