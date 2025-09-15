<?php

namespace Middlewares;

use Src\Middleware;
use Src\Request;

class TokenMiddleware extends Middleware
{
    public function handle(Request $request): bool
    {
        $token = $request->header('Authorization');

        if (!$token || strpos($token, 'Bearer ') !== 0) {
            return false;
        }

        $token = substr($token, 7); // Убираем "Bearer "

        if (!$user = app()->auth::checkByToken($token)) {
            return false;
        }

        $request->set('user', $user);
        return true;
    }
}