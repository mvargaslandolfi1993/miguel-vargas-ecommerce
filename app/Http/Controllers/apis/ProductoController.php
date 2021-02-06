<?php

namespace App\Http\Controllers\apis;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    /*
        Estructura Json para crear productos
         {
            "nombre": "Zapato",
            "cantidad" : 2,
            "idVendedor" : 1,
            "idCategoria" : 1,
            "descripcion" : "Opcional"
        }
    */
    public function create(Request $request)
    {
        $response = [
            "error"     => false,
            "errores"   => [],
            "data"      => []
        ];

        $data = $request->only('nombre','cantidad','idVendedor', 'idCategoria');

        $validator = Validator::make($data, [
            'nombre'      => ['required', 'string', 'max:255'],
            'cantidad'    => 'required',
            'idVendedor'  => 'required',
            'idCategoria' => 'required'  
        ]);
        
        if ($validator->fails()) {
            $response['error'] = true;
            $response['errores']  = $validator->messages();
            return response()->json($response ,422);
        }

        if ($request->cantidad <= 0) {
            $response['error'] = true;
            $response['errores']  = "La cantidad del producto no puede ser menor o igual a 0";
            return response()->json($response,422);
        }

        $existe = Categoria::where('idCategoria', $request->idCategoria)->exists();
        
        if (!$existe) {
            $response['error'] = true;
            $response['errores']  = "La categoria del producto no existe!";
            return response()->json($response,422);
        }else{
            $userExists = User::where("id", $data['idVendedor'])->where('admin', 1)->exists();
            if (!$userExists) {
                $response['error'] = true;
                $response['errores']  = "El Vendedor no concuerda con nuestros registros!";
                return response()->json($response,422);
            }else{
                $producto = Producto::create([
                    'nombre'        => $data['nombre'],
                    'cantidad'      => $data['cantidad'],
                    'idVendedor'    => $data['idVendedor'],
                    'descripcion'   => $request->descripcion ? $request->descripcion : null
                ]);
            }

            if ($producto->exists) {
                $response['data'] = 'El producto '.$producto->nombre.' se creó exitosamente.';
                return response()->json($response, 201);
            }else{
                $response['error'] = true;
                $response['errores'] = "El producto no se pudo crear";
                return response()->json($response, 500);
            }    
        }
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Producto::class);
        
        $response = [
            "error"     => false,
            "errores"   => [],
            "data"      => []
        ];

        $producto = Producto::find($id);
        
        if (is_null($producto)) {
            $response['error'] = true;
            $response['errores'] = "El id del producto ingresado no concuerda con nuestros registros";
            return response()->json($response, 500);
        }else{
            if (!is_null($request->cantidad) && $request->cantidad <= 0) {
               $response['error'] = true;
                $response['errores']  = "La cantidad del producto no puede ser menor o igual a 0";
                return response()->json($response, 422);
            }

            $userExists = User::where("id", $request->idVendedor)->where('admin', 1)->exists();
            if (!is_null($request->idVendedor) && !$userExists) {
                $response['error'] = true;
                $response['errores']  = "El Vendedor no concuerda con nuestros registros!";
                return response()->json($response,422);
            }

            $values = [
                "idVendedor"  => $request->idVendedor ? $request->idVendedor : $producto->idVendedor,
                "nombre"      => $request->nombre ? $request->nombre : $producto->nombre,
                "descripcion"   => $request->descripcion ? $request->descripcion : $producto->descripcion,
                "cantidad"      => $request->cantidad ? $request->cantidad : $producto->cantidad,
                "estado"        => $request->estado ? $request->estado : $producto->estado
            ];
            $update = Producto::where('idProducto', $id)->update($values);
            $response['data'] = "Producto actualizado con exito!";
            return response()->json($response, 201);
        }
    }

    public function delete($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();    
        $response['data'] = "Producto eliminado con exito!";
        return response()->json(["message" => "Producto eliminado con exito!"], 201); 
    }
}
