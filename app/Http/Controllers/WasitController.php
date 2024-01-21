<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\User;
use App\Models\VerificationStatus;
use App\Models\Wasit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wasit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['cabors'] = Cabor::all();

        return view('wasit.create', $datas);
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
            return redirect()->back()->with('error', 'Data wasit gagal disimpan');
        }
        $data['user_id'] = $newUser->id;

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/wasit-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data wasit gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['status_id'] = 3;

        $ok = Wasit::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data wasit gagal disimpan');
        }

        return redirect('/wasit')->with('success', 'Data wasit berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['wasit'] = Wasit::find($id);
        $datas['statuses'] = VerificationStatus::all();

        if (!$datas['wasit']->image) {
            $datas['wasit']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('wasit.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['wasit'] = Wasit::find($id);
        $datas['cabors'] = Cabor::all();

        if (!$datas['wasit']->image) {
            $datas['wasit']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('wasit.edit', $datas);
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

        $userData['name'] = $data['name'];
        $userData['username'] = $data['nik'];
        $userData['password'] = bcrypt($data['nik']);
        $userData['phone'] = $data['phone'];

        $userId = Wasit::find($id)->user_id;

        if ((User::find($userId)->username != $userData['username']) && (User::where('username', $userData['username'])->count() > 0)) {
            return redirect()->back()->with('error', 'Username (NIK) sudah digunakan')->withInput();
        }

        $updatedUser = User::find($userId)->update($userData);
        if (!$updatedUser) {
            return redirect()->back()->with('error', 'Data wasit gagal diubah');
        }

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/wasit-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data wasit gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Wasit::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data wasit gagal diubah');
        }

        return redirect('/wasit')->with('success', 'Data wasit berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Wasit::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data wasit gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data wasit berhasil dihapus');
    }

    public function wasitDatatable(Request $request)
    {
        $verified = $request->verified ?? 1;

        if ($verified == 1) {
            $wasits = Wasit::where('status_id', 3)->orderBy('id', 'desc')->get();
        } else {
            $wasits = Wasit::where('status_id', '!=', 3)->orderBy('id', 'desc')->get();
        }


        foreach ($wasits as $wasit) {
            $wasit['cabor_string'] = $wasit->cabor->name;
            $wasit['ttl_string'] = $wasit->birth_place.' / '.$wasit->birth_date;
            $wasit['status_string'] = $wasit->status->name;
        }

        return datatables()->of($wasits)->addIndexColumn()->toJson();
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $data = $request->only('status_id');

        $wasit = Wasit::find($id);

        if ($request->status_id == 3) {
            $ok = User::find($wasit->user_id)->update(['role_id' => 10]);
            if (!$ok) {
                return redirect()->back()->with('error', 'Status wasit gagal diubah');
            }
        } else {
            $ok = User::find($wasit->user_id)->update(['role_id' => 90]);
            if (!$ok) {
                return redirect()->back()->with('error', 'Status wasit gagal diubah');
            }
        }

        $ok = $wasit->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Status wasit gagal diubah');
        }

        return redirect('/wasit')->with('success', 'Status wasit berhasil diubah');
    }

    public function registrationIndex()
    {
        return view('wasit.registration');
    }
}
