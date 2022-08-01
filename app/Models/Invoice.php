<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'nro_factura',
        'subtotal',
        'iva',
        'total',
        'user_id',
        'trasmitter_id',
        'receptor_id',
        'creado',
        'actualizado'
    ];
}
