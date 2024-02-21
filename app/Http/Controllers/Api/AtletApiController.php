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
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'province' => 'required',
            'city' => 'required',
            'school' => 'required',
            'nis' => 'required',
            'email' => 'required',
            'no_rek' => 'required',
            'bank' => 'required',
            'lini' => 'required',
            'klasifikasi' => 'required',
            'image' => 'required',
            'kk_img' => 'required',
            'kartu_pelajar' => 'required',
            'akte' => 'required',
            'raport' => 'required',
            'sertif_penghargaan' => 'required',
            'sertif_kejuaraan' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if(isset($data['addCabor'])){

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
                    'message' => 'Data gambar atlet gagal disimpan',
                ], 400);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        if ($request->kk_img) {
            $imageDestination = 'attachment/'.date('Y/m').'/kk';
            $fileUploaded = $request->kk_img;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['kk_img'] = $imageDestination.'/'.$fileName;
        }

        if ($request->kartu_pelajar) {
            $imageDestination = 'attachment/'.date('Y/m').'/kartu_pelajar';
            $fileUploaded = $request->kartu_pelajar;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['kartu_pelajar'] = $imageDestination.'/'.$fileName;
        }

        if ($request->akte) {
            $imageDestination = 'attachment/'.date('Y/m').'/akte';
            $fileUploaded = $request->akte;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['akte'] = $imageDestination.'/'.$fileName;
        }

        if ($request->raport) {
            $imageDestination = 'attachment/'.date('Y/m').'/raport';
            $fileUploaded = $request->raport;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['raport'] = $imageDestination.'/'.$fileName;
        }

        if ($request->sertif_penghargaan) {
            $imageDestination = 'attachment/'.date('Y/m').'/sertif_penghargaan';
            $fileUploaded = $request->sertif_penghargaan;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['sertif_penghargaan'] = $imageDestination.'/'.$fileName;
        }

        if ($request->sertif_kejuaraan) {
            $imageDestination = 'attachment/'.date('Y/m').'/sertif_kejuaraan';
            $fileUploaded = $request->sertif_kejuaraan;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['sertif_kejuaraan'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;
        $data['keterangan'] = 'WAITING';

        $ok = Atlet::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data atlet gagal disimpan',
            ], 400);
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

        if(isset($data['addCabor'])){

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
                    'message' => 'Data gambar atlet gagal disimpan',
                ], 400);
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        if ($request->kk_img) {
            $imageDestination = 'attachment/'.date('Y/m').'/kk';
            $fileUploaded = $request->kk_img;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['kk_img'] = $imageDestination.'/'.$fileName;
        }

        if ($request->kartu_pelajar) {
            $imageDestination = 'attachment/'.date('Y/m').'/kartu_pelajar';
            $fileUploaded = $request->kartu_pelajar;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['kartu_pelajar'] = $imageDestination.'/'.$fileName;
        }

        if ($request->akte) {
            $imageDestination = 'attachment/'.date('Y/m').'/akte';
            $fileUploaded = $request->akte;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['akte'] = $imageDestination.'/'.$fileName;
        }

        if ($request->raport) {
            $imageDestination = 'attachment/'.date('Y/m').'/raport';
            $fileUploaded = $request->raport;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['raport'] = $imageDestination.'/'.$fileName;
        }

        if ($request->sertif_penghargaan) {
            $imageDestination = 'attachment/'.date('Y/m').'/sertif_penghargaan';
            $fileUploaded = $request->sertif_penghargaan;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['sertif_penghargaan'] = $imageDestination.'/'.$fileName;
        }

        if ($request->sertif_kejuaraan) {
            $imageDestination = 'attachment/'.date('Y/m').'/sertif_kejuaraan';
            $fileUploaded = $request->sertif_kejuaraan;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Berkas atlet gagal disimpan',
                ], 400);
            }

            $data['sertif_kejuaraan'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 1;

        $ok = Atlet::find($request->id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data atlet gagal disimpan',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Perubahan Data Pendaftaran Atlet Success',
        ]);
    }
}
