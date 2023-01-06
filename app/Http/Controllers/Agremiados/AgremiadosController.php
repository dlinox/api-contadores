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
        $this->response['message'] = 'Exito';
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
                Pago::where('idpago', $idpago)->delete();
                DB::delete("DELETE FROM pago_detalle WHERE idpago = $idpago;");
                DB::delete("DELETE FROM pago_voucher WHERE idpago = $idpago;");
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
}
