<?php
namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use Tinywan\Jwt\JwtToken;

class AuthCheck implements MiddlewareInterface
{
    public function process(Request $request, callable $next) : Response
    {
        try {
            $request->user = JwtToken::getExtend();
            
        } catch (\Throwable $th) {
            return json(['code' => 10001, 'msg' => '身份验证失败']);
        }
        return $next($request);
    }
}