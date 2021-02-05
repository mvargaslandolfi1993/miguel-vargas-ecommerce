<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Transaccion;
use App\Models\CategoriaProducto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->count(50)->create();
        //$producto = Categoria::factory()->count(50)->create();
         Producto::factory()->count(10)->create(["idVendedor" => rand(1,50)])->each(function($producto) 
         {
         	$categoria = Categoria::factory()->count(1)->create()->each(function($categoria) use ($producto) {
         		$categoriaProducto = CategoriaProducto::factory()->count(1)->create([
	                'idCategoria'   => $categoria->idCategoria,
	                'idProducto'    => $producto->idProducto
	            ]);	
     		});
     	
         	$transaccion = Transaccion::factory()->count(1)->create([
                'idComprador'   => rand(1, 50),
                'idProducto'    => $producto->idProducto
            ]);
        });
        
    }
}
