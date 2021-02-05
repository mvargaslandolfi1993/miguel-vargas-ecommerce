<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaProducto extends Model
{
    use HasFactory;
    protected $table = "categoria_producto";
    public $timestamps = false;
}
