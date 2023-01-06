<?php

namespace App\Http\Controllers\Agremiados\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agremiado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $response = [
        'message' => 'success',
        'ok' => false,
        'token' => null,
        'usuario' => null

    ];

    public function Login(Request $request)
    {
        $user = Agremiado::where('login', $request->colegiatura)->first();

        $token =  $user->createToken('Mobil')->plainTextToken;
        $this->response = [
            'ok' => true,
            'usuario' => (object)[
                "nombre" => $user->nombres . ' ' . $user->paterno . ' ' . $user->materno,
                "colegiatura" => $request->colegiatura,
                "correo" =>  $user->email,
                "matricula" => $user->nummat,
                "direccion" => $user->direccion,
                "dni" => $user->dni,
                "movil" => $user->movil,
            ],
            'token' => $token,
            'message' => 'success',
        ];

        return response()->json($this->response, 200);
    }

    public function me()
    {
        $user = Auth::user();

        $this->response = [
            'ok' => true,
            'usuario' => (object)[
                "nombre" => $user->nombres . ' ' . $user->paterno . ' ' . $user->materno,
                "colegiatura" => '0000',
                "correo" =>  $user->email,
                "matricula" => $user->nummat,
                "direccion" => $user->direccion,
                "dni" => $user->dni,
                "movil" => $user->movil,
            ],
            'message' => 'Datos de usuario',
        ];

        return response()->json($this->response, 200);
    }

    public function buscarAgremiado($nummat)
    {

        $user = Agremiado::where('nummat', $nummat)
            ->where('password', '')
            ->where('login', '')
            ->first();

        if ($user) {
            $this->response = [
                'ok' => true,
                'agremiado' => (object)[
                    'id' => $user->idagremiado,
                    "nombre" => $user->nombres . ' ' . $user->paterno . ' ' . $user->materno,
                    "correo" =>  $user->email ? $user->email : '',
                    "matricula" => $user->nummat,
                ],
                'message' => 'success',
            ];
            return response()->json($this->response, 200);
        } else {
            $this->response = [
                'ok' => false,
                'message' => 'Usuario no encontrado o ya tiene una cuenta',
            ];
            return response()->json($this->response, 200);
        }
    }
}
