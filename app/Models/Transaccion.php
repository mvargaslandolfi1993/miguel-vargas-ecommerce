<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaccion extends Model
{
    use HasFactory;
    protected $table = "transacciones";
	protected $primaryKey = "idTransaccion";
	protected $guarded = [
		'created_at', 'updated_at'
	];
}
