<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Pemuda;
use App\Models\User;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemudaController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pemudas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['cabors'] = Cabor::all();

        return view('pemudas.create', $datas);
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

        if($request->all_member != ($request->male_member + $request->female_member))  return redirect()->back()->withInput()->with('error', 'Jumlah member tidak sesuai');

        $userData['name'] = $data['leader'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['phone'];
        $userData['role_id'] = 20;

        if (User::where('username', $userData['username'])->count() > 0) {
            return redirect()->back()->withInput()->with('error', 'Username (NIK) sudah digunakan');
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
        }
        $data['user_id'] = $newUser->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }
        if ($request->document) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
            $fileUploaded = $request->document;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
            }

            $data['document'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 3;

        $ok = Pemuda::create($data);
        if (!$ok) {
            return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
        }

        return redirect('/pemudas')->with('success', 'Data pemuda berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['pemudas'] = Pemuda::find($id);
        $datas['statuses'] = VerificationStatus::all();

        return view('pemudas.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['pemudas'] = Pemuda::find($id);
        $datas['cabors'] = Cabor::all();

        return view('pemudas.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        $data = $request->except(['_token', '_method', 'image']);

        if($request->all_member != ($request->male_member + $request->female_member))  return redirect()->back()->withInput()->with('error', 'Jumlah member tidak sesuai');

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }
        if ($request->document) {
            $imageDestination = 'attachment/'.date('Y/m').'/pemuda-dokumen';
            $fileUploaded = $request->document;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
            }

            $data['document'] = $imageDestination.'/'.$fileName;
        }

        $ok = Pemuda::find($id)->update($data);

        if (!$ok) {
            return redirect()->back()->with('error', 'Pemuda gagal disimpan');
        }

        return redirect('/pemudas')->with('success', 'Pemuda berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Pemuda::find($id)->delete();

        if (!$ok) {
            return redirect()->back()->with('error', 'Pemuda gagal dihapus');
        }

        return redirect()->back()->with('success', 'Pemuda berhasil dihapus');
    }

    public function pemudaDatatable()
    {
        $pemudas = Pemuda::all();
        foreach ($pemudas as $pemuda) {
            $pemuda['cabor_string'] = $pemuda->cabor->name;
            $pemuda['status_string'] = $pemuda->status->name;
        }

        return datatables()->of($pemudas)->addIndexColumn()->toJson();
    }
}
