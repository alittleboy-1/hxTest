<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class Frist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $token = $request->header('X-CSRF-TOKEN');
        $token = $request->header('token');
        // print_r($token
        // print_r($token) ;
        if (!$token) {
            return response()->json([
                'code' => 401,
                'msg' => '请登录'
            ]);
        }
        $user = Redis::get($token);
        $ttl = Redis::ttl($token);
        if ($ttl < 4000) { //小于一千秒就加时间
            Redis::setex($token, 3600, json_encode($user));
        }

        if (!$user) {
            return response()->json([
                'code' => 401,
                'msg' => '请登录'
            ]);
        }
        $user = json_decode($user, true); 
        // print_r($user);
        if (!isset($user[0]['id'])) {
            return response()->json([
                'code' => 401,
                'msg' => '用户异常情重新登录1'
            ]);
        }
        $res = DB::table('users')->where('id', $user[0]['id'])->first();
        if (!$res) {
            return response()->json([
                'code' => 401,
                'msg' => '用户异常情重新登录2'
            ]);
        }

        return $next($request);
    }
}
