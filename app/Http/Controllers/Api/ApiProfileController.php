<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ApiProfileController extends Controller
{
    public function getProfiles(Request $request)
    {
        // $profiles = Profile::all();

        // if ($request->search) {
        //     $profiles = $profiles->where('title', 'LIKE', "%$request->search%");
        // }

        $profiles = Profile::orderBy('created_at', 'desc');

        $size = $request->size ?? 5;
        $page = $request->page ?? 1;
        $offset = $size * ($page - 1);

        $profilesCount = $profiles->count();
        $profilesData = $profiles->skip($offset)->take($size)->get();

        $lastPage = false;
        $pagesCount = $profilesCount / $size;
        $lastPageNumber = ceil($pagesCount);

        if ($page == $lastPageNumber || $profilesCount == 0) {
            $lastPage = true;
        }

        $maxWords = 25;
        $contentData = [];
        foreach ($profilesData as $profileData) {
            $profileData->description = str_replace('</p><p>', '. ', $profileData->description);
            $profileData->description = str_replace('<p>', '', $profileData->description);
            $profileData->description = str_replace('</p>', '', $profileData->description);

            $words = str_word_count($profileData->description, 2);

            if (count($words) > $maxWords) {
                $words = array_slice($words, 0, $maxWords);
                $profileData->description = implode(' ', $words) . '...';
            }

            array_push($contentData, [
                'id' => $profileData->id,
                'name' => $profileData->name,
                'birth_place' => $profileData->birth_place,
                'birth_date' => $profileData->birth_date,
                'address' => $profileData->address,
                'phone' => $profileData->phone,
                'judul' => $profileData->judul,
                'deskripsi_pendek' => $words,
                'deskripsi' => $profileData->description,
                'gambar' => $profileData->image
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

    public function getProfileById($id)
    {
        $profile = Profile::find($id);

        $profile->description = str_replace('</p><p>', '. ', $profile->description);
        $profile->description = str_replace('<p>', '', $profile->description);
        $profile->description = str_replace('</p>', '', $profile->description);

        $words = str_word_count($profile->description, 2);
        $maxWords = 25;
        if (count($words) > $maxWords) {
            $words = array_slice($words, 0, $maxWords);
            $profile->description = implode(' ', $words) . '...';
        }

        $data = [];

        if ($profile) {
            $data = [
                'id' => $profile->id,
                'name' => $profile->name,
                'birth_place' => $profile->birth_place,
                'birth_date' => $profile->birth_date,
                'address' => $profile->address,
                'phone' => $profile->phone,
                'judul' => $profile->judul,
                'deskripsi_pendek' => $words,
                'deskripsi' => $profile->description,
                'gambar' => $profile->image
            ];
        }

        return response()->json([
            'code' => 200,
            'message' => "success",
            'data' => $data
        ]);
    }
}
