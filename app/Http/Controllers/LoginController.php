<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function index()
    {
        return view('index'); 
    }

    public function authenticate(Request $request)
    {
        // $credentials = $request->only('name','');
        $request->validate([
            'name' => 'required',
        ]);

        $user = User::where('name', $request->input('name'))->first();
        if ($user) {
        Auth::login($user);
        if ($user->role == 'superadmin') {
                return redirect()->intended('/inventory')->with('success', 'Berhasil Login!'); // Arahkan ke dashboard superadmin.
            } elseif ($user->role == 'sales') {
                return redirect()->intended('/sales')->with('success', 'Berhasil Login!'); // Arahkan ke dashboard sales.
            } elseif ($user->role == 'purchase') {
                return redirect()->intended('/purchase')->with('success', 'Berhasil Login!'); // Arahkan ke dashboard purchase.
            } elseif ($user->role == 'manager') {
                return redirect()->intended('')->with('success', 'Berhasil Login!'); // Arahkan ke dashboard purchase.
            }
        }   
        else {
            return redirect()->back()->with('error', 'Gagal Login!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
