<?php

namespace App\Http\Resources;

use App\Models\Categoria;
use App\Models\CategoriaProducto;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaProductoCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $categoria = Categoria::where('idCategoria', $this->idCategoria)->first();
        $values = [
            'idCategoria'   => $categoria->idCategoria,
            'nombre'        => $categoria->nombre,
            'descripcion'   => $categoria->descripcion
        ];
        return $values;
    }
}
