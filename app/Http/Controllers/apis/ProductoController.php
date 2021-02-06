<?php

namespace App\Http\Controllers\apis;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductoCollection;

class ProductoController extends Controller
{
    public function getProductos()
    {
        return ProductoCollection::collection(Producto::paginate(5));
    }

    public function getProducto($id)
    {
        return ProductoCollection::collection(Producto::where('idProducto', $id)->get());
    }
    public function create()
    {

    }

    public function store()
    {

    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}
