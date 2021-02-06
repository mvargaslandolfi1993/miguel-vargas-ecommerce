<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Models\CategoriaProducto;

class ProductoCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'idProducto'    => $this->idProducto,
            'idVendedor'    => $this->when(Auth::user()->admin, 'idVendedor'),
            'nombre'        => $this->nombre,
            'descripcion'   => $this->descripcion,
            'cantidad'      => $this->cantidad,
            'estado'        => $this->estado,
            'categorias'    => CategoriaProductoCollection::collection(CategoriaProducto::where('idProducto',$this->idProducto)->get()),
        ];
    }
}
