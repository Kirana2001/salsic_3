<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class ApiNotificationController extends Controller
{
    public function getNotif(Request $req){
        if(!$req->user_id) {
            return response()->json([
                'code' => 400,
                'message' => 'id user diperlukan',
            ], 400);
        }
        $notif = Notification::where('user_id', $req->user_id)->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $notif,
        ]);
    }

    public function readNotif($id){
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
