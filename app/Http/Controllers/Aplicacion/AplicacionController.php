<?php

namespace App\Http\Controllers\Aplicacion;

use App\Http\Controllers\Controller;
use App\Models\Agremiado;
use App\Models\Habilidad;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AplicacionController extends Controller
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


    public function index()
    {

        return Inertia::render('Aplicacion/Home/index', [
            'tap' => 'home',
            'habil' => $this->agremiado->getEstadoHabil(),
            'pagos' => $this->pago->getPagoPendiente($this->user->idagremiado),

        ]);
    }

    public function pagosView()
    {
        return Inertia::render('Aplicacion/Pagos/index', [
            'tap' => 'pagos',
        ]);
    }

    public function pagosViewFormulario(Request $request)
    {
        # code...
    }

    public function certificadosView()
    {
        return Inertia::render('Aplicacion/Certificados/index', [
            'tap' => 'certificados',
        ]);
    }

    public function tramitesView()
    {
        return Inertia::render('Aplicacion/Tramites/index', [
            'tap' => 'tramites',
        ]);
    }
}
