<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Arena;
use App\Models\ArenaLending;
use App\Models\Documents;
use App\Models\LendingStatus;
use App\Models\NumberSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArenaApiController extends Controller
{
    public function index()
    {
        $arenas = Arena::all();
        $arenas->makeHidden(['created_at', 'updated_at', 'deleted_at']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $arenas
        ]);
    }

    public function show(Request $request)
    {
        $arena = Arena::find($request->id);
        $arena->makeHidden(['created_at', 'updated_at', 'deleted_at']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $arena
        ]);
    }

    public function lendArena(Request $request)
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
            return response()->json([
                'code' => 400,
                'message' => 'arena telah dipinjam pada rentang waktu tersebut',
            ]);
        }

        $numberSetting = NumberSetting::first();
        $numbArenaLending = $numberSetting->no_arena_lending;
        $numbArenaLending += 1;
        $data['number'] = 'P/ARN/'.date('dmY').'/'.str_pad($numbArenaLending, 4, '0', STR_PAD_LEFT);
        $numberSetting->no_arena_lending = $numbArenaLending;
        $numberSetting->update();

        $ok = ArenaLending::create($data);
        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'error',
            ]);
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
                    'arena_id' => $ok->id
                );
                Documents::create($data);
            }
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
        ]);
    }

    public function lendHistory()
    {
        $arenas = ArenaLending::where('user_id', Auth::user()->id)->get();

        $responseData = [];

        foreach ($arenas as $arena) {
            array_push($responseData, [
                'id' => $arena->id,
                'number' => $arena->number,
                'arena_name' => Arena::find($arena->arena_id)->name,
                'status' => LendingStatus::find($arena->status_id)->name,
                'application_date' => $arena->application_date
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $responseData
        ]);
    }

    public function lendHistoryDetail(Request $request)
    {
        $arena = ArenaLending::where('user_id', Auth::user()->id)->find($request->id);
        $arena->arena_name = Arena::find($arena->arena_id)->name;
        $arena->status = LendingStatus::find($arena->status_id)->name;
        $arena->makeHidden(['arena_id', 'status_id', 'created_at', 'updated_at', 'deleted_at']);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $arena
        ]);
    }
}
