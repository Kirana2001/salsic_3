<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profiles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['cabors'] = Cabor::all();

        return view('profiles.create', $datas);
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
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'header' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/profiles-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data profile gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Profile::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data profile gagal disimpan');
        }

        return redirect('/profiles')->with('success', 'Data profile berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['profile'] = Profile::find($id);

        if (!$datas['profile']->image) {
            $datas['profile']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('profiles.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['profile'] = Profile::find($id);
        $datas['cabors'] = Cabor::all();

        if (!$datas['profile']->image) {
            $datas['profile']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('profiles.edit', $datas);
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
            'cabor_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'header' => 'required',
            'description' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/profiles-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data profile gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Profile::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data profile gagal diubah');
        }

        return redirect('/profiles')->with('success', 'Data profile berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Profile::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data profile gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data profile berhasil dihapus');
    }

    public function profileDatatable(Request $request)
    {
        $profiles = Profile::all();

        foreach ($profiles as $profile) {
            $profile['cabor_string'] = $profile->cabor->name;
            $profile['ttl_string'] = $profile->birth_place.' / '.$profile->birth_date;
        }

        return datatables()->of($profiles)->addIndexColumn()->toJson();
    }
}
