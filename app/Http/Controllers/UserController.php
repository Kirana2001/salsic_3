<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas['roles'] = Role::all();

        return view('users.create', $datas);
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
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if (User::where('username', $data['username'])->count() > 0) {
            return redirect()->back()->with('error', 'Username sudah digunakan')->withInput();
        }

        $data['password'] = bcrypt($data['password']);

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/users-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'User gagal disimpan');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = User::create($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'User gagal disimpan')->withInput();
        }

        return redirect('/users')->with('success', 'User berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas['user'] = User::find($id);

        if (!$datas['user']->image) {
            $datas['user']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('users.show', $datas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas['user'] = User::find($id);
        $datas['roles'] = Role::all();

        if (!$datas['user']->image) {
            $datas['user']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('users.edit', $datas);
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
            'name' => 'required',
            'username' => 'required',
            'role_id' => 'required'
        ]);

        $data = $request->except(['_token', '_method', 'password', 'image']);

        if ((User::find($id)->username != $data['username']) && (User::where('username', $data['username'])->count() > 0)) {
            return redirect()->back()->with('error', 'Username sudah digunakan')->withInput();
        }

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/users-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'User gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = User::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'User gagal diubah')->withInput();
        }

        return redirect('/users')->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ok = User::find($id)->delete();
        if (!$ok) {
            return redirect()->back()->with('error', 'User gagal dihapus')->withInput();
        }

        return redirect('/users')->with('success', 'User berhasil dihapus');
    }

    public function usersDatatable()
    {
        $users = User::orderBy('id')->get();

        foreach ($users as $user) {
            $user['role_string'] = $user->role->name;
        }

        return datatables()->of($users)->addIndexColumn()->toJson();
    }

    public function ubahPassView()
    {
        return view('users.ubah_password');
    }

    public function ubahPassSubmit(Request $request, $id)
    {
        $request->validate([
            'password_lama'=>'required',
            'password_baru'=>'required',
            'konfirmasi_password'=>'required',
        ]);

        $user = User::find($id);
        if($request->get('password_baru') != $request->get('konfirmasi_password')){
            return redirect()->back()->with('error', 'Password baru tidak sama dengan password konfirmasi');
        }

        if(Hash::check($request->get('password_lama'), $user->password)){
            $user->password = bcrypt($request->get('password_baru'));
            $user->save();

            return redirect('/ubah-password')->with('success', 'Password berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Password lama salah');
        }
    }

    public function profile()
    {
        $userId = Auth::user()->id;

        $datas['user'] = User::find($userId);

        if (!$datas['user']->image) {
            $datas['user']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('users.profile', $datas);
    }

    public function editProfile()
    {
        $id = Auth::user()->id;
        $datas['user'] = User::find($id);

        if (!$datas['user']->image) {
            $datas['user']->image = 'global_assets/images/placeholders/placeholder.jpg';
        }

        return view('users.edit_profile', $datas);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'name' => 'required',
            'username' => 'required'
        ]);

        $data = $request->except(['_token', '_method', 'image']);

        if ((User::find($id)->username != $data['username']) && (User::where('username', $data['username'])->count() > 0)) {
            return redirect()->back()->with('error', 'Username sudah digunakan')->withInput();
        }

        if ($request->image) {
            $imageDestination = 'attachment/'.date('Y/m').'/users-image';
            $fileUploaded = $request->image;
            $fileName = Auth::user()->id.'-'.time().'.'.$fileUploaded->getClientOriginalExtension();
            $moved = $fileUploaded->move($imageDestination, $fileName);

            if (!$moved) {
                return redirect()->back()->with('error', 'Profile gagal diubah');
            }

            $data['image'] = $imageDestination.'/'.$fileName;
        }

        $ok = User::find($id)->update($data);
        if (!$ok) {
            return redirect()->back()->with('error', 'Profile gagal diubah')->withInput();
        }

        return redirect('/profile')->with('success', 'Profile berhasil diubah');
    }
}
