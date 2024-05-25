<?php

namespace App\Http\Controllers;

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

        $curent_user = User::where('id', Auth::user()->id)->first();

        $roles = $curent_user->getRoleNames();

        if ('admin' != $roles[0]) {
            return redirect('/');
        }

        $users = User::get();

        $data = [
            'title' => 'Semua User',
            'users' => $users,
        ];

        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->status == 'tidak aktif') {
            $data = [
                'title' => 'nonactive',
            ];
            return view('pages.user.nonactive', $data);
        }
        $user = User::where('id', $id)->first();

        $data = [
            'title' => 'test',
            'user' => $user,
        ];

        return view('pages.user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


        if ($request->destroy == 'true') {
            $user = User::where('id', $id)->first();
            $user->delete();
            return redirect('/user')->withSuccess('User deleted successfully');
        }

        $user = User::find($id);
        $resort = $user->resort;
        if ($request->resort != '') {
            $resort = $request->resort;
        }
        $status = $user->status;
        if ($request->status != '') {
            $status = $request->status;
        }
        $password = $user->password;
        if ($request->password != '') {
            $password = Hash::make($request->password);
        }

        // return print_r($request->all());


        $user->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'resort' => $resort,
            'email' => $request->email,
            'password' => $password,
            'status' => $status,
        ]);

        $data = [
            'title' => 'Input user',
            'user' => $user,
        ];

        return view('pages.nasabah.add-notif', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
