<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabor;
use App\Models\Pelatih;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'no_kk' => 'required',
            'gender' => 'required',
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'school' => 'required',
            'email' => 'required',
            'no_rek' => 'required',
            'bank' => 'required',
            'lini' => 'required',
            'klasifikasi' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if($data['addCabor'] != null){

            $createCabor = Cabor::firstOrCreate(['name' => $data['addCabor']]);
            $data['cabor_id'] = $createCabor->id;
        }

        $data['user_id'] = Auth::user()->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pelatih-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data gambar pelatih gagal disimpan',
                ], 400);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;

        // return response()->json(['data' => $data]);

        $ok = Pelatih::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data pelatih gagal disimpan',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Pendaftaran Pelatih Success',
        ]);
    }

    public function index()
    {

        $datas = Pelatih::where('user_id', Auth::user()->id)->get();

        foreach ($datas as $data) {
            $data->cabor = Cabor::find($data->cabor_id)->name;
            $data->status = VerificationStatus::find($data->status_id)->name;
        }

        $datas->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $datas,
        ]);
    }

    public function show(Request $request)
    {

        $data = Pelatih::where('user_id', Auth::user()->id)->find($request->id);
        $data->cabor = Cabor::find($data->cabor_id)->name;
        $data->status = VerificationStatus::find($data->status_id)->name;
        $data->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at']);

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
            'nik' => 'required',
            'no_kk' => 'required',
            'gender' => 'required',
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'school' => 'required',
            'email' => 'required',
            'no_rek' => 'required',
            'bank' => 'required',
            'lini' => 'required',
            'klasifikasi' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if($data['addCabor'] != null){

            $createCabor = Cabor::firstOrCreate(['name' => $data['addCabor']]);
            $data['cabor_id'] = $createCabor->id;
        }

        $data['user_id'] = Auth::user()->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pelatih-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data gambar pelatih gagal disimpan',
                ], 400);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;

        $ok = Pelatih::find($request->id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data Pelatih gagal disimpan',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Perubahan Data Pendaftaran Pelatih Success',
        ]);
    }
}
