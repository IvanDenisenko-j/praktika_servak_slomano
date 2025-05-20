<?php

namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return new View('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            return new View('site.signup', ['message'=>'Вы успешно зарегистрированы']);
        }
        return new View('site.signup');
    }
}