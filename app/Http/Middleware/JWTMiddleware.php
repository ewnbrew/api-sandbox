<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'success' => false,
                     'error' => 'User not found.'
                    ], 404);
            }
        } catch (TokenExpiredException $e) {
            try {
                $newToken = JWTAuth::refresh(JWTAuth::getToken());
                JWTAuth::setToken($newToken)->toUser();
                $request->headers->set('Authorization','Bearer '. $newToken);
            } catch (JWTException $e){
                return response()->json([
                    'code'   => 103,
                    'message' => 'Token cannot be refreshed, please Login again'
                ]);
            }
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                 'error' => 'Login Token invalid.', $e->getMessage()
                ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        return $next($request);
    }
}
