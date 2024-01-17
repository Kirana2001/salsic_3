<?php

namespace App\Http\Controllers;

use App\Models\Arena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arena.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arena.create');
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
            'ownership' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'facilities' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/arena-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data arena gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Arena::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data arena gagal disimpan');
        }

        return redirect('/arena')->with('success', 'Data arena berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['arena'] = Arena::find($id);

        if (!$datas['arena']->image) {
            $datas['arena']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('arena.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['arena'] = Arena::find($id);

        if (!$datas['arena']->image) {
            $datas['arena']->image = 'global_assets/images/placeholders/cover.jpg';
        }

        return view('arena.edit', $datas);
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
            'ownership' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'facilities' => 'required',
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/arena-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data arena gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Arena::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data arena gagal diubah');
        }

        return redirect('/arena')->with('success', 'Data arena berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Arena::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data arena gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data arena berhasil dihapus');
    }

    public function arenaDatatable()
    {
        $arenas = Arena::all();

        return datatables()->of($arenas)->addIndexColumn()->toJson();
    }
}
