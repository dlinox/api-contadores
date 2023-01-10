<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoVoucher extends Model
{
    use HasFactory;

    protected $table = 'pago_voucher';
    protected $primaryKey = 'iddetalle';
    public $timestamps = false;
    protected $fillable = [
        'numvoucher',
        'fecha',
        'importe',
        'idpago',
        'imagen',
    ];
}
