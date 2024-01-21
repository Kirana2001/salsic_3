<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Atlet;
use App\Models\Cabor;
use App\Models\User;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtletApiController extends Controller
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
            $imageDestination = 'attachment/'.date('Y/m').'/atlets-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'error',
                ]);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;

        $ok = Atlet::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'error',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Pendaftaran Atlet Success',
        ]);
    }

    public function index()
    {

        $datas = Atlet::where('user_id', Auth::user()->id)->get();

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

        $data = Atlet::where('user_id', Auth::user()->id)->find($request->id);
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
            $imageDestination = 'attachment/'.date('Y/m').'/atlets-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'error',
                ]);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;

        $ok = Atlet::find($request->id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'error',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Perubahan Data Pendaftaran Atlet Success',
        ]);
    }
}
