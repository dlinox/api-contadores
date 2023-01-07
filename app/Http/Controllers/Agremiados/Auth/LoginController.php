<?php

namespace App\Http\Controllers\Agremiados\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agremiado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Agremiado::where('login', $request->colegiatura)
            ->where('password', sha1($request->clave))
            ->first();

        if ($user) {
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
                    "habil" => $user->situacion,
                ],
                'token' => $token,
                'message' => 'success',
            ];
            return response()->json($this->response, 200);
        } else {
            $this->response = [
                'ok' => false,
                'usuario' => (object)[
                    "nombre" => '',
                    "colegiatura" => '',
                    "correo" =>  '',
                    "matricula" => '',
                    "direccion" => '',
                    "dni" => '',
                    "movil" => '',
                    "habil" => '',
                ],
                'token' => '',
                'message' => 'Error',
            ];
            return response()->json($this->response, 400);
        }

       
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
                "habil" => $user->situacion,
            ],
            'message' => 'Datos de usuario',
        ];

        return response()->json($this->response, 200);
    }

    public function buscarAgremiado($nummat, $dni)
    {

        $user = Agremiado::where('nummat', $nummat)
            ->where('dni', $dni)
            ->where(DB::raw("login = '' OR password = '' OR password IS NULL OR login IS NULL"))
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
