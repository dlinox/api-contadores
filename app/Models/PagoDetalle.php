<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    use HasFactory;

    protected $table = 'pago_detalle';

    public $timestamps = false;
    //protected $primaryKey = 'idpago';

    protected $fillable = [
        'idpago',
        'idconcepto',
        'cantidad',
        'precio',
        'cuotas',
    ];
}
