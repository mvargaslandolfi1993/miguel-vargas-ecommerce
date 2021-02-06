<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Transaccion;
use App\Models\CategoriaProducto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Vendedor Fake User */
        $admin  = new User();

        $admin->nombre              = "Admin";
        $admin->email               = "admin@ecommerce.com";
        $admin->password            = Hash::make("12345678");
        $admin->email_verified_at   = now();
        $admin->remember_token      = Str::random(10);
        $admin->verificado          = true;
        $admin->verificacion_token  = true;
        $admin->admin               = true;
        $admin->save();
        /* Admin Fake User */

        $user = User::factory()->count(50)->create();
         Producto::factory()->count(20)->create(["idVendedor" => 1])->each(function($producto) 
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
