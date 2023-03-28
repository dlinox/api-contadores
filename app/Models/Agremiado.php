<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Agremiado extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'agremiado';
    protected $primaryKey = 'idagremiado';

    protected $fillable = [
        'email',
        'password',
        'login',
        'movil',
        'direccion',
    ];

    public $timestamps = false;


    static public function getEstadoHabil()
    {
        $user =  Auth::user()->idagremiado;
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero'];
        $num_meses = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '01', '02'];

        $estado =  DB::select(
            "SELECT ultimopago, current_date fecha_actual
            from agremiado 
            where flag='T' 
            and idagremiado='{$user}'"
        )[0];


        $flag = false;
        $habil = false;
        $hasta = "";

        if ($estado) {
            $flag = true;

            $fecha_actual = (string)$estado->fecha_actual;

            if (!is_null($estado->ultimopago) and $estado->ultimopago != '') {
                $anio = substr($estado->ultimopago, 0, 4);
                $idmes = substr($estado->ultimopago, 4, 2);

                $mes_letras_hasta = $meses[(int)$idmes + 1];
                $mes_hasta = $num_meses[(int)$idmes + 1];

                if ($idmes >= 11) {
                    $anio_hasta = $anio + 1;
                } else {
                    $anio_hasta = $anio;
                }
                $anio_actual = substr($fecha_actual, 0, 4);
                $mes_actual = substr($fecha_actual, 5, 2);

                $num_actual = (int)($anio_actual . $mes_actual);
                $num_hasta = (int)($anio_hasta . $mes_hasta);

                if ($num_actual <= $num_hasta) {
                    $habil = true;
                    $hasta = $mes_letras_hasta . ' de ' . $anio_hasta;
                }
            }
        }

        $response['flag'] = $flag;
        $response['habil'] = $habil;
        $response['hasta'] = $hasta;
        $response['ok'] = true;
        return $response;
    }
}
