<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\VerificationStatus;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{
    public function getEvents(Request $request)
    {
        $events = Event::where('status_id', '3');

        if ($request->search) {
            $events = $events->where('title', 'LIKE', "%$request->search%");
        }

        $events = $events->orderBy('start_date');

        $size = $request->size ?? 5;
        $page = $request->page ?? 1;
        $offset = $size * ($page - 1);

        $eventsCount = $events->count();
        $eventsData = $events->skip($offset)->take($size)->get();

        $lastPage = false;
        $pagesCount = $eventsCount / $size;
        $lastPageNumber = ceil($pagesCount);

        if ($page == $lastPageNumber || $eventsCount == 0) {
            $lastPage = true;
        }

        // $maxWords = 25;
        $contentData = [];
        foreach ($eventsData as $eventData) {
            $eventData->description = str_replace('</p><p>', '. ', $eventData->description);
            $eventData->description = str_replace('<p>', '', $eventData->description);
            $eventData->description = str_replace('</p>', '', $eventData->description);
            $eventData->description = str_replace('<br>', '', $eventData->description);

            $words = str_word_count($eventData->description, 2);

            // if (count($words) > $maxWords) {
            //     $words = array_slice($words, 0, $maxWords);
            //     $eventData->description = implode(' ', $words) . '...';
            // }

            array_push($contentData, [
                'id' => $eventData->id,
                'judul' => $eventData->header,
                'tanggal_mulai' => $eventData->start_date,
                'tanggal_selesai' => $eventData->end_date,
                'jam_mulai' => $eventData->start_time,
                'jam_selesai' => $eventData->end_time,
                'gambar' => $eventData->image,
                'deskripsi' => $eventData->description
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

    public function getEventById($id)
    {
        $event = Event::find($id);

        $data = [];

        if ($event) {
            $data = [
                'id' => $event->id,
                'judul' => $event->header,
                'tanggal_mulai' => $event->start_date,
                'tanggal_selesai' => $event->end_date,
                'jam_mulai' => $event->start_time,
                'jam_selesai' => $event->end_time,
                'gambar' => $event->image,
                'deskripsi' => $event->description
            ];
        }

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }
}
