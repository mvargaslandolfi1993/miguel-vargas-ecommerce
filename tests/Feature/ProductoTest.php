<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_update_producto_usuario_vendedor()
    {
        $user = User::where('admin', 1)->first();
        
        $token = $this->json('POST', '/api/auth/login', ['email' => $user->email, 'password' => '12345678']);

        $this->assertAuthenticated($guard = null);

        $response = $this->actingAs($user, 'api')
        ->withHeaders([
            'Authorization' => 'Bearer'." ".$token->original['access_token'],
        ])
        ->withSession(['banned' => false])
        ->json('POST', '/api/update/producto/1', ['nombre' => 'Zapato', 'descripcion' => "Zapatos para hombres"]);

        $response->assertSuccessful();
    }

    public function test_can_update_producto_usuario_cliente()
    {
        $user = User::where('admin', 0)->first();
        $token = $this->json('POST', '/api/auth/login', ['email' => $user->email, 'password' => '12345678']);

        $this->assertAuthenticated($guard = null);
        
        $response = $this->actingAs($user, 'api')
        ->withHeaders([
            'Authorization' => 'Bearer'." ".$token->original['access_token'],
        ])
        ->withSession(['banned' => false])
        ->json('POST', '/api/update/producto/1', ['nombre' => 'Zapato', 'descripcion' => "Zapatos para hombres"]);

        $response->assertUnauthorized();        
    }
}
