<?php

namespace App\Http\Controllers\Aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagosController extends Controller
{

    public function index()
    {
        return Inertia::render('Aplicacion/Pagos/index', [
            'tap' => 'pagos',
        ]);
    }

    public function create()
    {
        return Inertia::render('Aplicacion/Pagos/formulario');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
