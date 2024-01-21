<?php

namespace App\Http\Controllers;

use App\Models\Arena;
use App\Models\ArenaLending;
use App\Models\Documents;
use App\Models\LendingStatus;
use App\Models\NumberSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArenaLendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arena_lending.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['arenas'] = Arena::all();

        return view('arena_lending.create', $datas);
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
            'application_date' => 'required',
            'name' => 'required',
            'nik' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'arena_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'jenis_kegiatan' => 'required',
            'nama_kegiatan' => 'required',
            'purpose' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $data['user_id'] = Auth::user()->id;
        $data['status_id'] = 1;

        $existLending = ArenaLending::where('arena_id', $data['arena_id'])
                        ->where('status_id', 3)
                        ->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                        ->orWhere('arena_id', $data['arena_id'])
                        ->where('status_id', 3)
                        ->whereBetween('end_date', [$data['start_date'], $data['end_date']])->get();

        if ($existLending->count() > 0) {
            return redirect()->back()->with('error', 'Telah ada peminjaman pada rentang tanggal tersebut');
        }

        $numberSetting = NumberSetting::first();
        $numbArenaLending = $numberSetting->no_arena_lending;
        $numbArenaLending += 1;
        $data['number'] = 'P/ARN/'.date('dmY').'/'.str_pad($numbArenaLending, 4, '0', STR_PAD_LEFT);
        $numberSetting->no_arena_lending = $numbArenaLending;
        $numberSetting->update();

        $ok = ArenaLending::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data peminjaman arena gagal disimpan');
        }
        if ($request->document) {
            foreach($request->document as $key=>$value){
                $imageDestination = 'attachment/'.date('Y/m').'/lend-arena-dokumen';
                $fileUploaded = $value;
                $fileName = Auth::user()->id.'-'.time().'-'.$key.'.'.$fileUploaded->getClientOriginalExtension();
                $moved = $fileUploaded->move($imageDestination, $fileName);

                $file = $imageDestination.'/'.$fileName;
                $data = array(
                    'name' => $file,
                    'arena_id' => $ok->id,
                    'flag' => $ok->nama_kegiatan
                );
                Documents::create($data);
            }
        }

        return redirect('/peminjaman-arena')->with('success', 'Data peminjaman arena berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['arenaLending'] = ArenaLending::find($id);
        $datas['statuses'] = LendingStatus::all();
        $datas['documents'] = Documents::where('arena_id', $datas['arenaLending']->id)->get();

        return view('arena_lending.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['arenaLending'] = ArenaLending::find($id);
        $datas['arenas'] = Arena::all();
        $datas['documents'] = Documents::where('arena_id', $datas['arenaLending']->id)->get();

        return view('arena_lending.edit', $datas);
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
            'application_date' => 'required',
            'name' => 'required',
            'nik' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'arena_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'jenis_kegiatan' => 'required',
            'nama_kegiatan' => 'required',
            'purpose' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        $data['user_id'] = Auth::user()->id;

        $existLending = ArenaLending::where('arena_id', $data['arena_id'])
                        ->where('status_id', 3)
                        ->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                        ->orWhere('arena_id', $data['arena_id'])
                        ->where('status_id', 3)
                        ->whereBetween('end_date', [$data['start_date'], $data['end_date']])->get();

        if ($existLending->count() > 0) {
            foreach ($existLending as $lending) {
                if ($lending->id != $id) {
                    return redirect()->back()->with('error', 'Telah ada peminjaman pada tanggal awal peminjaman yang dipilih');
                }
            }
        }

        $ok = ArenaLending::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Data peminjaman arena gagal diubah');
        }

        if ($request->document) {
            foreach($request->document as $key=>$value){
                $imageDestination = 'attachment/'.date('Y/m').'/lend-arena-dokumen';
                $fileUploaded = $value;
                $fileName = Auth::user()->id.'-'.time().'-'.$key.'.'.$fileUploaded->getClientOriginalExtension();
                $moved = $fileUploaded->move($imageDestination, $fileName);

                $file = $imageDestination.'/'.$fileName;
                $data = array(
                    'name' => $file,
                    'arena_id' => $ok->id,
                    'flag' => $ok->nama_kegiatan
                );
                Documents::create($data);
            }
        }

        return redirect('/peminjaman-arena')->with('success', 'Data peminjaman arena berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = ArenaLending::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'Data peminjaman arena gagal dihapus');
        }

        return redirect()->back()->with('success', 'Data peminjaman arena berhasil dihapus');
    }

    public function arenaLendingDatatable()
    {
        $arenaLendings = ArenaLending::orderBy('id', 'desc')->get();

        foreach ($arenaLendings as $arenaLending) {
            $arenaLending['arena_string'] = $arenaLending->arena->name;
            $arenaLending['status_string'] = $arenaLending->status->name;
        }

        return datatables()->of($arenaLendings)->addIndexColumn()->toJson();
    }

    public function updateArenaLendingStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required',
        ]);

        $data = $request->only('status_id');

        $arenaLending = ArenaLending::find($id);

        if ($request->status_id == 3) {
            $existLending = ArenaLending::where('arena_id', $arenaLending->arena_id)
                            ->where('status_id', 3)
                            ->whereBetween('start_date', [$arenaLending->start_date, $arenaLending->end_date])
                            ->orWhere('arena_id', $arenaLending->arena_id)
                            ->where('status_id', 3)
                            ->WhereBetween('end_date', [$arenaLending->start_date, $arenaLending->end_date])->get();

            if ($existLending->count() > 0) {
                foreach ($existLending as $lending) {
                    if ($lending->id != $id) {
                        return redirect()->back()->with('error', 'Telah ada peminjaman pada tanggal awal peminjaman yang dipilih');
                    }
                }
            }
        }

        $ok = $arenaLending->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Status peminjaman arena gagal diubah');
        }

        return redirect('/peminjaman-arena')->with('success', 'Status peminjaman arena berhasil diubah');
    }
}
