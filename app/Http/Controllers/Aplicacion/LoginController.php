<?php

namespace App\Http\Controllers\Aplicacion;

use App\Http\Controllers\Controller;
use App\Models\Agremiado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
       // $this->middleware('guest:admin')->except('logout');
    }


    public function index()
    {
        return Inertia::render('Aplicacion/Auth/Login');
    }

    public function signIn(Request $request)
    {
        $user = Agremiado::where('login', $request->login)
            ->where('password', sha1($request->password))
            ->first();

        if ($user) {
            Auth::login($user);

            $request->session()->regenerate();

            return Redirect::route('app.home')->with(
                [
                    'message' => 'Ingresando',
                    'status' => true,
                ]
            );
        }

        return back()->with([
            'message' => 'Credenciales incorrectas.',
            'status' => false
        ]);
    }

    public function signUp(Request $request)
    {
        # 
    }
}
