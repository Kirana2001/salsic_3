<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentApiController extends Controller
{
    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'document' => 'required',
            'flag' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $key => $fileUploaded) {
                $allowedFileTypes = ['jpg', 'jpeg', 'png', 'pdf'];
                if (!in_array($fileUploaded->getClientOriginalExtension(), $allowedFileTypes)) {
                    return response()->json(['message' => 'Tipe file tidak diizinkan'], 400);
                }

                $maxFileSize = 5000;
                if ($fileUploaded->getSize() > $maxFileSize) {
                    return response()->json(['message' => 'Ukuran file terlalu besar'], 400);
                }

                $imageDestination = 'attachment/' . date('Y/m') . '/attachment-documents';
                $fileName = Auth::user()->id . '-' . time() . '-' . $key . '.' . $fileUploaded->getClientOriginalExtension();

                $moved = $fileUploaded->move($imageDestination, $fileName);

                if ($moved) {
                    $document = new Documents();
                    $document->name = $imageDestination . '/' . $fileName;
                    if ($data['pemuda_id'] != null && $data['pemuda_id'] != "") {
                        $document->pemuda_id = $data['pemuda_id'];
                    }
                    if ($data['arena_id'] != null && $data['arena_id'] != "") {
                        $document->pemuda_id = $data['arena_id'];
                    }
                    $document->save();
                } else {
                    return response()->json(['message' => 'Gagal menyimpan file'], 400);
                }
            }

            return response()->json(['message' => 'File berhasil diupload']);
        }

        return response()->json(['message' => 'Tidak ada file yang diupload'], 400);
    }
}
