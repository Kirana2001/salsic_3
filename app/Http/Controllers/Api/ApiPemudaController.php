<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabor;
use App\Models\Documents;
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
            'cabor_id' => 'required',
            'founder' => 'required',
            'leader' => 'required',
            'secretary' => 'required',
            'treasurer' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'document' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'document']);

        $data['user_id'] = Auth::user()->id;

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

        $data['status_id'] = 3;

        $ok = Pemuda::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data pemuda gagal disimpan',
            ]);
        }

        if ($request->document) {
            foreach($request->document as $key=>$value){
                $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
                $fileUploaded = $value;
                $fileName = Auth::user()->id.'-'.time().'-'.$key.'.'.$fileUploaded->getClientOriginalExtension();
                $moved = $fileUploaded->move($imageDestination, $fileName);

                $file = $imageDestination.'/'.$fileName;
                $data = array(
                    'name' => $file,
                    'pemuda_id' => $ok->id,
                    'flag' => $ok->organization_name
                );
                Documents::create($data);
            }
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data pemuda berhasil disimpan',
        ]);
    }

    public function show(Request $request)
    {
        $data = Pemuda::where('user_id', Auth::user()->id)->find($request->id);
        if(!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ]);
        }
        $data->cabor = Cabor::find($data->cabor_id)->name;
        $data->status = VerificationStatus::find($data->status_id)->name;
        $documents = [];
        $getDocuments = Documents::where('pemuda_id', $data->id)->get();
        foreach ($getDocuments as $document) {
            $fileContent = asset($document->name);
            array_push($documents, $fileContent);
            // $fileContent = file_get_contents($document->name);
            // array_push($documents, base64_encode($fileContent));
        }
        $data->documents = $documents;
        $data->makeHidden(['cabor_id', 'status_id', 'created_at', 'updated_at', 'deleted_at', 'nik', 'founding_date', 'village', 'subdistrict', 'district', 'city', 'province', 'all_member', 'image']);

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
            'cabor_id' => 'required',
            'founder' => 'required',
            'leader' => 'required',
            'secretary' => 'required',
            'treasurer' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'document' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'document']);

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

        $ok = Pemuda::find($id)->update($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Data pemuda gagal disimpan',
            ]);
        }

        if ($request->document) {
            foreach($request->document as $key=>$value){
                $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
                $fileUploaded = $value;
                $fileName = Auth::user()->id.'-'.time().'-'.$key.'.'.$fileUploaded->getClientOriginalExtension();
                $moved = $fileUploaded->move($imageDestination, $fileName);

                $file = $imageDestination.'/'.$fileName;
                $data = array(
                    'name' => $file,
                    'pemuda_id' => $ok->id,
                    'flag' => $ok->organization_name
                );
                Documents::create($data);
            }
        }

        return response()->json([
            'code' => 200,
            'message' => 'Data pemuda berhasil disimpan',
        ]);
    }
}
