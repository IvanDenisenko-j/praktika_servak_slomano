<?php


namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не авторизован или не админ, то редирект на страницу входа
        if (!Auth::isAdmin()) {
            app()->route->redirect('/login');
        }
    }
}