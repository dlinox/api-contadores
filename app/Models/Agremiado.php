<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    ];

    public $timestamps = false;
}
