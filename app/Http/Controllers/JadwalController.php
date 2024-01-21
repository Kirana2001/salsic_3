<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Jadwal;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jadwal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['cabors'] = Cabor::all();

        return view('jadwal.create', $datas);
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
            'cabor_id' => 'required',
            'tim_a' => 'required',
            'tim_b' => 'required',
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/jadwals-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data jadwal gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $data['skor_a'] = 0;
        $data['skor_b'] = 0;
        $data['status_id'] = 1;

        $ok = Jadwal::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data jadwal gagal disimpan');
        }

        return redirect('/jadwal')->with('success', 'Data jadwal berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['jadwal'] = Jadwal::find($id);
        $datas['cabors'] = Cabor::all();
        $excludedIds = [2, 3, 4];

        $datas['statuses'] = VerificationStatus::all()->reject(function ($status) use ($excludedIds) {
            return in_array($status->id, $excludedIds);
        });

        return view('jadwal.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['jadwal'] = Jadwal::find($id);
        $datas['cabors'] = Cabor::all();
        $datas['statuses'] = VerificationStatus::all();

        return view('jadwal.edit', $datas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cabor_id' => 'required',
            'tim_a' => 'required',
            'tim_b' => 'required',
            'skor_a' => 'required',
            'skor_b' => 'required',
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
            'image' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/jadwals-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Data jadwal gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = Jadwal::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data jadwal gagal disimpan');
        }

        return redirect('/jadwal')->with('success', 'Data jadwal berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jadwal  $jadwal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = Jadwal::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data jadwal gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data jadwal berhasil dihapus');
    }

    public function jadwalDatatable(Request $request)
    {
        $jadwals = Jadwal::orderBy('id', 'desc')->get();

        foreach ($jadwals as $jadwal) {
            $jadwal['cabor_string'] = $jadwal->cabor->name;
            $jadwal['pertandingan'] = $jadwal->tim_a.' - '.$jadwal->tim_b;
            $jadwal['skor'] = $jadwal->skor_a.' - '.$jadwal->skor_b;
            $jadwal['status_string'] = $jadwal->status->name;
        }

        return datatables()->of($jadwals)->addIndexColumn()->toJson();
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $data = $request->only('status_id');

        $jadwal = Jadwal::find($id);

        $ok = $jadwal->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Status jadwal gagal diubah');
        }

        return redirect('/jadwal')->with('success', 'Status jadwal berhasil diubah');
    }
}
