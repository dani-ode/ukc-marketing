<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('/')
                ->withSuccess('Signed in');
        }
        return view('pages.auth.login');
    }

    public function customLogin(Request $request)
    {
        $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                ->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("login")->withErrors($validator);
    }



    public function registration()
    {
        if (Auth::check()) {
            return redirect()->intended('/')
                ->withSuccess('Signed in');
        }
        return view('pages.auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'resort' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        if ($check) {
            return redirect("login")->withSuccess('You have signed-in');
        }

        // return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {

        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'resort' => $data['resort'],
            'password' => Hash::make($data['password'])
        ]);


        $user->assignRole('editor');
        $user->givePermissionTo('marketing');

        return $user;
    }

    // public function dashboard()
    // {
    //     if (Auth::check()) {
    //         return view('pages.nasabah.index');
    //     }

    //     return redirect("login")->withSuccess('You are not allowed to access');
    // }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
