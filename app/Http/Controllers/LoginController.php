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

        $name = $request->input('name');
        $user = User::where('name', $name)->first();

        if ($user) {
            Auth::login($user);

            return response()->json(['role' => $user->role]);
        } else {
            // User not found
            return response()->json(['role' => 'unknown']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
