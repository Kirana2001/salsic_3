<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Documents;
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

        $userData['name'] = $data['organization_name'];
        $userData['username'] = str_replace(' ','_',$data['organization_name']);
        $userData['password'] = bcrypt('salsic2024');
        $userData['phone'] = $data['phone'];
        $userData['role_id'] = 40;

        if (User::where('username', $userData['username'])->count() > 0) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan');
        }

        $newUser = User::create($userData);
        if (!$newUser) {
            return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
        }
        $data['user_id'] = $newUser->id;

        $data['status_id'] = 1;

        $ok = Pemuda::create($data);
        if (!$ok) {
            return redirect()->back()->withInput()->with('error', 'Data pemuda gagal disimpan');
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
        $datas['documents'] = Documents::where('pemuda_id', $datas['pemudas']->id)->get();

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
        $datas['documents'] = Documents::where('pemuda_id', $datas['pemudas']->id)->get();
// dd($datas['documents']);
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

        $ok = Pemuda::find($id)->update($data);

        if (!$ok) {
            return redirect()->back()->with('error', 'Pemuda gagal disimpan');
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
        $pemudas = Pemuda::orderBy('id', 'desc')->get();
        foreach ($pemudas as $pemuda) {
            $pemuda['cabor_string'] = $pemuda->cabor->name;
            $pemuda['status_string'] = $pemuda->status->name;
            $pemuda['user'] = $pemuda->user->username;
            $pemuda['documents'] = Documents::where('pemuda_id', $pemuda->id)->get();
        }

        return datatables()->of($pemudas)->addIndexColumn()->toJson();
    }

    public function registrationIndex()
    {
        return view('pemudas.registration');
    }
}
