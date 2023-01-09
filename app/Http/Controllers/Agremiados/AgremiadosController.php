<?php

namespace App\Http\Controllers\Agremiados;

use App\Http\Controllers\Controller;
use App\Mail\RegistroMail;
use App\Models\Agremiado;
use App\Models\Habilidad;
use App\Models\Pago;
use App\Models\PagoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AgremiadosController extends Controller
{
    //
    protected $pago;
    protected $agremiado;
    protected $habilidad;

    protected $user;
    protected $response;


    public function __construct()
    {
        $this->pago = new Pago();
        $this->habilidad = new Habilidad();
        $this->agremiado = new Agremiado();
        $this->user = Auth::user();
    }

    public function getPagosPendientes()
    {
        $pagos =  $this->pago->getPagoPendiente($this->user->idagremiado);
        $this->response['data'] = $pagos;
        $this->response['message'] = 'Exito';
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }

    public function getDetallePagos(Request $request)
    {
        $anio = $request->anio;
        $tipo = $request->tipo;

        $pagos_detalle =  $this->pago->getDetallePagos($this->user->idagremiado, $anio, $tipo);
        $this->response['data'] = $pagos_detalle;
        $this->response['message'] = 'Exito Tipo: '  . $tipo . ' Anio: ' . $anio;
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }

    public function getDetalleHabilidad()
    {
        $hablidad_detalle =  $this->habilidad->getDetalle($this->user->idagremiado);
        $this->response['data'] = $hablidad_detalle;
        $this->response['message'] = 'Exito';
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }

    public function guardarPago(Request $request)
    {


        if ($request->file('file')) {

            try {
                DB::transaction(function () use ($request) {
                    $pago = $this->pago->create([
                        'idagremiado' => $this->user->idagremiado,
                        'total' => $request->total,
                    ]);

                    PagoDetalle::create([
                        'idpago' => $pago->idpago,
                        'idconcepto' => $request->concepto,
                        'cantidad' => $request->cantidad,
                        'precio' => $request->precio,
                        //'cuotas' => ,
                    ]);
                });


                $this->response['message'] = 'Exito';
                $this->response['ok'] = true;
                return response()->json($this->response, 200);
            } catch (\Throwable $th) {

                $this->response['message'] =  $th;
                $this->response['ok'] = false;
                return response()->json($this->response, 200);
            }
        } else {
            //$this->response['data'] = $hablidad_detalle;
            $this->response['message'] = 'Exito con foto :)';
            $this->response['ok'] = true;
            return response()->json($this->response, 400);
        }
    }


    function crearUsuario(Request $request)
    {
        $agremiado = Agremiado::where('idagremiado', $request->id)
            ->first();
        $agremiado->email = $request->email;
        DB::transaction(function () use ($agremiado) {
            $password =  Str::random(8);
            $agremiado->password =  sha1($password);
            $agremiado->login =  $agremiado->dni;

            $data = (object)[
                'nombre' => $agremiado->nombres . ' ' . $agremiado->paterno . ' ' . $agremiado->materno,
                'email' => $agremiado->email,
                'password' =>  $password,
                'dni' => $agremiado->dni,
            ];

            $agremiado->save();

            Mail::to($agremiado->email)->send(new RegistroMail($data));
        });
    }
    public function getConceptos()
    {
        $this->response['data'] = $this->pago->getConceptos();
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }

    public function eliminarPago($idpago)
    {
        try {
            DB::transaction(function () use ($idpago) {
                DB::delete("DELETE FROM pago_voucher WHERE idpago = '$idpago';");
                DB::delete("DELETE FROM pago_detalle WHERE idpago = '$idpago';");
                DB::delete("DELETE FROM pago_deposito WHERE idpago = '$idpago';");
            });
            $this->response['message'] = 'Pago eliminado';
            $this->response['ok'] = true;
            return response()->json($this->response, 200);
        } catch (\Throwable $th) {
            $this->response['message'] = 'Ocurrio un error al eliminar el Pago' . $th;
            $this->response['ok'] = false;
            return response()->json($this->response, 400);
        }
    }


    public function getEstadoHabil()
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero', 'Febrero'];
        $num_meses = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '01', '02'];
        $estado =  DB::select(
            "SELECT ultimopago, current_date fecha_actual, paterno, materno, nombres 
            from agremiado 
            where flag='T' 
            and idagremiado='{$this->user->idagremiado}'"
        )[0];

        $flag = false;
        $habil = false;
        $nombre = "";
        $hasta = "";

        if ($estado) {
            $flag = true;
            $nombre = $estado->paterno . " " . $estado->materno . " " . $estado->nombres;
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

        $this->response['flag'] = $flag;
        $this->response['habil'] = $habil;
        $this->response['nombre'] = $nombre;
        $this->response['hasta'] = $hasta;
        $this->response['message'] = 'Ocurrio un error al eliminar el Pago';
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }


    public function getHastaHabil()
    {
        $row = DB::select("SELECT max(vd.cuotas) ultimo 
        FROM ventadetalle vd 
        LEFT JOIN venta v ON v.idventa = vd.idventa 
        LEFT JOIN agremiado a ON a.idagremiado = v.idagremiado 
        WHERE a.idagremiado = '{$this->user->idagremiado}' AND vd.idconcepto = '1' ")[0];

        if (!is_null($row->ultimo)) {
            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $anio = substr($row->ultimo, 0, 4);
            $idmes = substr($row->ultimo, -2);
            $mes = $meses[intval($idmes) - 1];
        } else {
            $mes = "";
            $anio = "";
        }
        $this->response['fecha'] = $mes . $anio;
        $this->response['message'] = 'Ocurrio un error al eliminar el Pago';
        $this->response['ok'] = true;
        return response()->json($this->response, 200);
    }

    public function editarDatoUsuario(Request $request)
    {

        $campo = $request->campo;
        $dato = $request->dato;
        //agremiado

        try {
            $dato = $campo == 'password' ? sha1($dato) : $dato;
            $resp =  $this->agremiado->where('idagremiado', $this->user->idagremiado)->update([$campo  => "$dato"]);

            if ($resp) {
                $this->response['message'] = 'Exito  -  sql: ' . $resp;
                $this->response['campo'] = $campo;
                $this->response['dato'] = $dato;
                // $this->response['query'] = $query;
                $this->response['ok'] = true;
                return response()->json($this->response, 200);
            }
            $this->response['message'] = 'Ocurrio un error 12 - ' . $resp;
            $this->response['campo'] = $campo;
            $this->response['dato'] = $dato;
            //  $this->response['query'] = $query;

            $this->response['ok'] = false;
            return response()->json($this->response, 400);
        } catch (\Throwable $th) {
            $this->response['message'] = $th;
            $this->response['campo'] = $campo;
            $this->response['dato'] = $dato;
            $this->response['ok'] = false;
            return response()->json($this->response, 400);
        }
    }

    public function dowlosdPDF()
    {

        //$this->response['ok'] = 'holas';
        //return response()->json($this->response, 400);

        header("Location: https://online.ccppuno.org.pe/habilidad/imprimir/2520/mqeiwqzcp5dcubgqkc6h");
        die();
    }
}
