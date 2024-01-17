<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabor;
use App\Models\Pemuda;
use App\Models\User;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPemudaController extends Controller
{
    public function index()
    {
        $datas = Pemuda::where('user_id', Auth::user()->id)->get();

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required',
            'founding_date' => 'required',
            'founder' => 'required',
            'leader' => 'required',
            'nik' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'village' => 'required',
            'subdistrict' => 'required',
            'district' => 'required',
            'city' => 'required',
            'province' => 'required',
            'all_member' => 'required',
            'male_member' => 'required',
            'female_member' => 'required',
            'document' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'document']);

        if($request->all_member != ($request->male_member + $request->female_member)) {
            return response()->json([
                'code' => 400,
                'message' => 'Jumlah member salah',
            ]);
        }

        $userData['name'] = $data['leader'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['phone'];
        $userData['role_id'] = 20;

        if (User::where('username', $userData['username'])->count() > 0) {
            return response()->json([
                'code' => 400,
                'message' => 'Username sudah terpakai',
            ]);
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return response()->json([
                'code' => 400,
                'message' => 'Gagal membuat user',
            ]);
        }
        $data['user_id'] = $newUser->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data pemuda gagal disimpan',
                ]);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }
        if ($request->document) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
            $fileUploaded = $request->document;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data pemuda gagal disimpan',
                ]);
            }

            $data['document'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 3;

        $ok = Pemuda::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data pemuda gagal disimpan',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data pemuda berhasil disimpan',
        ]);
    }

    public function show(Request $request)
    {
        $data = Pemuda::where('user_id', Auth::user()->id)->find($request->id);
        $data->cabor = Cabor::find($data->cabor_id)->name;
        $data->status = VerificationStatus::find($data->status_id)->name;
        $data->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required',
            'founding_date' => 'required',
            'founder' => 'required',
            'leader' => 'required',
            'nik' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'village' => 'required',
            'subdistrict' => 'required',
            'district' => 'required',
            'city' => 'required',
            'province' => 'required',
            'all_member' => 'required',
            'male_member' => 'required',
            'female_member' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'document']);

        if($request->all_member != ($request->male_member + $request->female_member)) {
            return response()->json([
                'code' => 400,
                'message' => 'Jumlah member salah',
            ]);
        }

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data pemuda gagal disimpan',
                ]);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }
        if ($request->document) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
            $fileUploaded = $request->document;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data pemuda gagal disimpan',
                ]);
            }

            $data['document'] = $imageDestination.'/'.$fileName;
        }

        $ok = Pemuda::find($id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data pemuda gagal disimpan',
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data pemuda berhasil disimpan',
        ]);
    }
}
