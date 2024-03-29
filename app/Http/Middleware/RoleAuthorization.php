<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        try {        
            $token = JWTAuth::parseToken();
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {       
            return $this->unauthorized('Token Expirado. Porfavor, inicia sesion nuevamente.');
        } catch (TokenInvalidException $e) {
            return $this->unauthorized('Token invalido. Porfavor, inicia sesion nuevamente.');
        }catch (JWTException $e) {
            return $this->unauthorized('Porfavor, coloca el Bearer Token en tu peticion');
        }

        if ($user && in_array($user->admin, $roles)) {
            return $next($request);
        }
         return $this->unauthorized();
    }
    private function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'No está autorizado para acceder a este recurso.',
            'success' => false
        ], 401);
    }
}
