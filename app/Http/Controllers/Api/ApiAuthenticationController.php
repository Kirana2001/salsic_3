<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NotifEmail;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiAuthenticationController extends Controller
{
    public function login() {
        $credential = [
            'username' => request('username'),
            'password' => request('password'),
        ];
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token');
            $token2 = $token->token;
            $token2->save();

            return response()->json([
                'code' => 200,
                'message' => 'Login Success',
                'data' => [
                    'token' => $token->accessToken,
                    'role' => [
                        'id' => @$user->id,
                        'role_id' => @$user->role_id,
                        'username' => @$user->username,
                    ]
                ]
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request',
                'data' => [
                    'errors' => [
                        'message' => 'Username or password incorrect, please try again!',
                    ]
                ]
            ], 400);
        }
    }

    public function cektoken(Request $request) {
        $authHeader = explode(' ', $request->get('token'));
        $token = $authHeader[0];

        $tokenParts = explode('.', $token);
        $tokenHeader = $tokenParts[1];

        $tokenHeaderJson = base64_decode($tokenHeader);
        $tokenHeaderArray = json_decode($tokenHeaderJson, true);
        $userToken = $tokenHeaderArray['jti'];

        $oauthUser = DB::table('oauth_access_tokens')->where('id', $userToken)->where('revoked', 0)->first();
        if ($oauthUser) {
            $expires = Carbon::parse($oauthUser->expires_at)->toDateString();
            $now = date('Y-m-d h:i:s');

            if ($expires > $now) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Token Valid',
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Token Invalid',
                ])(400, 'Success', 'Token Expired');
            }
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Token Invalid',
            ]);
        }
    }

    public function logout(Request $request) {
        return response()->json($request->user());

        $request->user()->token()->revoke();
        return response()->json([
            'code' => 200,
            'messsage' => 'Logout Success'
        ], 200);
    }

    public function lupapassword(Request $request) {
        $request->validate([
            'username' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan',
                'data' => [],
            ], 404);
        }

        $otp = random_int(100000, 999999);
        $expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $user->update([
            'otp' => $otp,
            'expired' => $expired,
        ]);

        $list['otp'] = $otp;

        Mail::to($user->email)->send(new NotifEmail($list));

        return response()->json([
            'code' => 200,
            'message' => 'Email berhasil dikirim',
            'data' => [
                'id' => $user->id,
            ],
        ], 200);
    }

    public function lupapasswordotp(Request $request) {
        $request->validate([
            'otp' => 'required',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan',
                'data' => [],
            ], 404);
        }

        if ($request->otp != $user->otp) {
            return response()->json([
                'code' => 400,
                'message' => 'OTP salah',
                'data' => [],
            ], 400);
        }

        if (date('Y-m-d H:i:s') > $user->expired) {
            return response()->json([
                'code' => 400,
                'message' => 'OTP expired',
                'data' => [],
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => [
                'id' => $user->id,
            ],
        ], 200);
    }

    public function lupapasswordinput(Request $request) {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan',
                'data' => [],
            ], 404);
        }

        $data = [
            'password' => bcrypt($request->password),
            'otp' => null,
            'expired' => null,
        ];

        $user->update($data);

        return response()->json([
            'code' => 200,
            'message' => 'Password berhasil diperbarui',
            'data' => [
                'id' => $user->id,
            ],
        ], 200);
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = $request->except(['_token']);

        $data['username'] = $data['email'];
        $data['password'] = bcrypt($data['password']);
        $data['role_id'] = 90;

        if(User::where('username',$request->email)->count() > 0){
            return response()->json([
                'code' => 400,
                'message' => 'Email sudah digunakan',
            ], 400);
        }

        $ok = User::create($data);

        if (!$ok) {
            return response()->json([
                'code' => 400,
                'message' => 'Pendaftaran gagal',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Pendaftaran berhasil',
        ], 200);
    }

    public function currentUser()
    {
        $user = Auth::user();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => Role::find($user->role_id)->name,
        ];

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data,
        ]);
    }
}
