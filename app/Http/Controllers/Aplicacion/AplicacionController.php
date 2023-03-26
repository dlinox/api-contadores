<?php

namespace App\Http\Controllers\Aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AplicacionController extends Controller
{
    public function index()
    {

        return Inertia::render('Aplicacion/Home/index', [
            'tap' => 'home',
        ]);
    }

    public function pagosView()
    {
        return Inertia::render('Aplicacion/Pagos/index', [
            'tap' => 'pagos',
        ]);
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
