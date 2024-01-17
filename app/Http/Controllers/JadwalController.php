<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use App\Models\Jadwal;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;

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
        ]);

        $data = $request->except(['_token', '_method']);

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
        ]);

        $data = $request->except(['_token', '_method']);

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
        // $verified = $request->verified ?? 1;

        // if ($verified == 1) {
        //     $jadwals = Jadwal::where('status_id', 3)->get();
        // } else {
        //     $jadwals = Jadwal::where('status_id', '!=', 3)->get();
        // }

        $jadwals = Jadwal::all();

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
