<?php

namespace App\Http\Controllers;

use App\Models\tbl_user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);
        
        if (Auth::attempt($validateData)) {
            // dd(Auth::user());
            $user = Auth::user();

            if($user->role == 'super_admin'){
                // Session::regenerateToken();
                return redirect('/akun')->with('success','Berhasil Masuk');
            } elseif($user->role == 'pengelola'){
                return redirect('/ruangan')->with('success','Berhasil Masuk');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function logout()
    {
        Auth::logout();
        Session::regenerateToken();
        return redirect('/');
    }
}
