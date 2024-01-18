<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class ApiJadwalController extends Controller
{
    public function getJadwal(Request $request)
    {
        $jadwal = Jadwal::where('status_id', '1');

        if ($request->search) {
            $jadwal = $jadwal->where('tim_a', 'LIKE', "%$request->search%")->orWhere('tim_b', 'LIKE', "%$request->search%");
        }

        $jadwal = $jadwal->orderBy('date')->orderBy('time');

        $size = $request->size ?? 5;
        $page = $request->page ?? 1;
        $offset = $size * ($page - 1);

        $jadwalCount = $jadwal->count();
        $jadwalDatas = $jadwal->skip($offset)->take($size)->get();

        $lastPage = false;
        $pagesCount = $jadwalCount / $size;
        $lastPageNumber = ceil($pagesCount);

        if ($page == $lastPageNumber || $jadwalCount == 0) {
            $lastPage = true;
        }

        // $maxWords = 25;
        $contentData = [];
        foreach ($jadwalDatas as $jadwalData) {



            array_push($contentData, [
                'id' => $jadwalData->id,
                'cabor_id' => $jadwalData->cabor_id,
                'cabor_name' => $jadwalData->cabor->name,
                'tim_a' => $jadwalData->tim_a,
                'tim_b' => $jadwalData->tim_b,
                'skor_a' => $jadwalData->skor_a,
                'skor_b' => $jadwalData->skor_b,
                'date' => $jadwalData->date,
                'time' => $jadwalData->time,
                'place' => $jadwalData->place
            ]);
        }
        $data = [
            'page' => $page,
            'size' => $size,
            'last_page' => $lastPage,
            'content' => $contentData
        ];

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }

    public function getJadwalById($id)
    {
        $jadwal = Jadwal::find($id);

        $data = [];

        if ($jadwal) {
            $data = [
                'id' => $jadwal->id,
                'cabor_id' => $jadwal->cabor_id,
                'cabor_name' => $jadwal->cabor->name,
                'tim_a' => $jadwal->tim_a,
                'tim_b' => $jadwal->tim_b,
                'skor_a' => $jadwal->skor_a,
                'skor_b' => $jadwal->skor_b,
                'date' => $jadwal->date,
                'time' => $jadwal->time,
                'place' => $jadwal->place
            ];
        }

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }
}
