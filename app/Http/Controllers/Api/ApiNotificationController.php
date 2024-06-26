<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ApiNotificationController extends Controller
{
    public function getNotif(Request $req){
        if(!Auth::user()->id) {
            return response()->json([
                'code' => 400,
                'message' => 'id user diperlukan',
            ], 400);
        }
        $notif = Notification::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $notif,
        ]);
    }

    public function readNotif($id){
        if(!Notification::find($id)) {
            return response()->json([
                'code' => 404,
                'message' => 'id notif tidak ditemukan',
            ], 404);
        }
        $getNotif = Notification::find($id)->update([
            'status' => 'read'
        ]);
        if(!$getNotif) {
            return response()->json([
                'code' => 400,
                'message' => 'gagal update notification',
            ], 400);
        }
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => 'notification updated',
        ]);
    }
}
