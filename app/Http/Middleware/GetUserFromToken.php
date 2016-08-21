<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Response;

class GetUserFromToken
{
    /**
     * 验证接口token
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return new Response(json_encode([
                    'status' => 'error',
                    'code' => 4003,
                    'message' => 'user不存在'
                ]));
            }

        } catch (TokenExpiredException $e) {

            return new Response(json_encode([
                'status' => 'error',
                'code' => 4002,
                'message' => 'token过期'
            ]));

        } catch (TokenInvalidException $e) {

            return new Response(json_encode([
                'status' => 'error',
                'code' => 4001,
                'message' => 'token无效'
            ]));

        } catch (JWTException $e) {

            return new Response(json_encode([
                'status' => 'error',
                'code' => 4000,
                'message' => '缺少token'
            ]));

        }
        return $next($request);
    }
}
