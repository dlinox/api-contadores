<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago_deposito';
    protected $primaryKey = 'idpago';

    protected $fillable = [
        'idagremiado',
        'total',
    ];

    public $timestamps = false;

    public function getPagoPendiente($agremiado)
    {
        return $this->select(
            'pago_deposito.idpago',
            'pago_deposito.estado',
            'pago_deposito.hora',
            'pago_deposito.total',
            'conceptopago.desconcepto',
            'pago_voucher.numvoucher',
            'pago_voucher.fecha',
            'pago_voucher.importe',
            'pago_voucher.imagen'
        )
            ->leftJoin('pago_detalle', 'pago_detalle.idpago', '=', 'pago_deposito.idpago')
            ->leftJoin('pago_voucher', 'pago_voucher.idpago', '=', 'pago_deposito.idpago')
            ->leftJoin('conceptopago', 'pago_detalle.idconcepto', '=', 'conceptopago.idconcepto')
            ->where('pago_deposito.idagremiado', $agremiado)
            ->where('pago_deposito.estado', '!=', '1')
            ->orderByDesc('pago_deposito.hora')
            ->get()->map(function ($pago) {
                return [
                    'id' => $pago->idpago,
                    'fecha' => $pago->hora,
                    'estado' => $pago->estado,
                    'concepto' => $pago->desconcepto,
                    'precio' => $pago->total,
                    'numvoucher' => $pago->numvoucher ? $pago->numvoucher : '' ,
                    'importe' => $pago->importe ? $pago->importe : '' ,
                    'fecha' => $pago->fecha  ? $pago->fecha : '',
                    'imagen' => $pago->image ? url("/uploads/{$pago->imagen}") : '',
                ];
            });
    }

    public function getDetallePagos($agremiado, $anio, $tipo)
    {
        return DB::select(
            "SELECT v.idventa id, v.anio, v.idserie, concat(v.idserie,'-',v.numero) numero, sum(round(vd.cantidad*vd.precio,2)) importe, DATE_FORMAT(v.fecha, '%d/%m/%Y') fecha, f.desforma, IF(v.idforma='5',v.clave,'') print 
                from ventadetalle vd 
                left join venta v on v.idventa = vd.idventa 
                left join formapago f on f.idforma = v.idforma 
                where v.anio like '$anio%' and v.idagremiado = '$agremiado' and f.desforma like '$tipo%' 
                GROUP BY v.idventa, v.anio, v.idserie, v.numero 
                order by v.anio, v.idserie, v.numero desc"
        );
    }

    public function getConceptos()
    {
        return  DB::select(
            "SELECT idconcepto, desconcepto, precio
            FROM conceptopago 
            WHERE flag_web='T' 
            ORDER BY idconcepto"
        );
    }
}
