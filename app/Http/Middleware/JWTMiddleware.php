<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return response()->json(['errors' => ['Token provided is invalid.']], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (TokenExpiredException $e) {
            return response()->json(['errors' => ['Token provided is expired.']], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['errors' => ['Auth token not found.']], HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
