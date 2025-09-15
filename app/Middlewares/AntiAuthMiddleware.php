<?php


namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AntiAuthMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь авторизован, то редирект
        if (Auth::check()) {
            app()->route->redirect('/employees');
        }
    }
}