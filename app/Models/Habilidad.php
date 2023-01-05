<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Habilidad extends Model
{
    use HasFactory;

    public function getDetalle($agremiado)
    {
        return DB::select(
            "select h.idhabilidad id, h.numero, h.fecha, h.hora_insert, h.emitir, h.vigencia, IF(isnull(h.iddetalle),'',concat(v.idserie,'-',v.numero)) recibo, IF(isnull(h.iddetalle),'Exonerado',f.desforma) desforma, IF((CURRENT_DATE < DATE_ADD(h.fecha, INTERVAL h.vigencia MONTH) AND h.emitir='1'),h.clave,h.clave) print 
            from habilidad h 
            left join ventadetalle vd on vd.iddetalle = h.iddetalle 
            left join venta v on v.idventa = vd.idventa 
            left join formapago f on f.idforma = v.idforma 
            where h.idagremiado = '$agremiado' 
            order by h.idhabilidad desc"
        );
    }
}
