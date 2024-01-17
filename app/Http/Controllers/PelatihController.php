<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pelatih.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['cabors'] = Cabor::all();

        return view('pelatih.create', $datas);
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
            'nik' => 'required',
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        $userData['name'] = $data['name'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['phone'];
        $userData['role_id'] = 20;

        if (User::where('username', $userData['username'])->count() > 0) {
            return redirect()->back()->with('error', 'Username (NIK) sudah digunakan');
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return redirect()->back()->with('error', 'Data pelatih gagal disimpan');
        }
        $data['user_id'] = $newUser->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pelatih-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data pelatih gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 3;

        $ok = Pelatih::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data pelatih gagal disimpan');
        }

        return redirect('/pelatih')->with('success', 'Data pelatih berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['pelatih'] = Pelatih::find($id);
        $datas['statuses'] = VerificationStatus::all();

        if (!$datas['pelatih']->image) {
            $datas['pelatih']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('pelatih.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['pelatih'] = Pelatih::find($id);
        $datas['cabors'] = Cabor::all();

        if (!$datas['pelatih']->image) {
            $datas['pelatih']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('pelatih.edit', $datas);
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
            'name' => 'required',
            'nik' => 'required',
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        $userData['name'] = $data['name'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['phone'];

        $userId = Pelatih::find($id)->user_id;

        if ((User::find($userId)->username != $userData['username']) && (User::where('username', $userData['username'])->count() > 0)) {
            return redirect()->back()->with('error', 'Username (NIK) sudah digunakan')->withInput();
        }

        $updatedUser = User::find($userId)->update($userData);
        if (!$updatedUser) {
            return redirect()->back()->with('error', 'Data pelatih gagal diubah');
        }

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/pelatih-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data pelatih gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Pelatih::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data pelatih gagal diubah');
        }

        return redirect('/pelatih')->with('success', 'Data pelatih berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Pelatih::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data pelatih gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data pelatih berhasil dihapus');
    }

    public function pelatihDatatable(Request $request)
    {
        $verified = $request->verified ?? 1;

        if ($verified == 1) {
            $pelatihs = Pelatih::where('status_id', 3)->get();
        } else {
            $pelatihs = Pelatih::where('status_id', '!=', 3)->get();
        }

        foreach ($pelatihs as $pelatih) {
            $pelatih['cabor_string'] = $pelatih->cabor->name;
            $pelatih['ttl_string'] = $pelatih->birth_place.' / '.$pelatih->birth_date;
            $pelatih['status_string'] = $pelatih->status->name;
        }

        return datatables()->of($pelatihs)->addIndexColumn()->toJson();
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $data = $request->only('status_id');

        $pelatih = Pelatih::find($id);

        if ($request->status_id == 3) {
            $ok = User::find($pelatih->user_id)->update(['role_id' => 10]);
            if (!$ok) {
                return redirect()->back()->with('error', 'Status pelatih gagal diubah');
            }
        } else {
            $ok = User::find($pelatih->user_id)->update(['role_id' => 90]);
            if (!$ok) {
                return redirect()->back()->with('error', 'Status pelatih gagal diubah');
            }
        }

        $ok = $pelatih->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Status pelatih gagal diubah');
        }

        return redirect('/pelatih')->with('success', 'Status pelatih berhasil diubah');
    }

    public function registrationIndex()
    {
        return view('pelatih.registration');
    }
}
