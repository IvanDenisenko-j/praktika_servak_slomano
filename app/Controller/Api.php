<?php

namespace Controller;

use Model\Post;
use Model\User;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Api
{

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function api_register(Request $request): string
    {
        $data = $request->all();
        $us = User::where('login', $data['login'])->first();
        if($us){
            return (new View())->toJSON([
                'error' => 'пользователь с таким логином уже существует',
            ], 422);
        }

        $user = User::create([
            'login' => $data['login'],
            'password' => md5((string)$data['password']),
            'name' => $data['name'] ?? '',
        ]);

        if ($user) {
            $auth = new Auth();
            $token = $auth->generateToken($user->id);
            return (new View())->toJSON([
                'message' => 'Пользователь зарегистрирован',
                'token' => $token,
            ]);
        }

        return (new View())->toJSON(['error' => 'Не удалось создать пользователя']);
    }

    public function api_login(Request $request): string
    {
        $credentials = $request->all();

        if (empty($credentials['login']) || empty($credentials['password'])) {
            return (new View())->toJSON([
                'error' => 'Логин и пароль обязательны для заполнения'
            ]);
        }

        try {
            $user = User::where('login', $credentials['login'])->first();

            if (!$user){
                return (new View())->toJSON([
                    'error' => 'пользователь не найден'
                ]);
            }

            if (md5((string)$credentials['password']) !== $user->passwor){
                return (new View())->toJSON([
                    'error' => 'неверный пароль',
                    'password' => md5((string)$credentials['password']),
                ]);
            };

            $auth = new Auth();
            $token = $auth->generateToken($user->id);

            return (new View())->toJSON([
                'message' => 'авторизация прошла успешно',
                'token' => $token,
                'user' => [
                    'login' => $user->login,
                    'name' => $user->name
                ]
            ], 200);

        }catch (\Exception $e){
            return (new View())->toJSON([
                'error' => 'ошибка валидации, попробуйте позже'
            ]);
        }

    }


    public function secure_data(Request $request): string
    {
        $user = $request->get('user');

        return (new View())->toJSON([
            'message' => 'Вы успешно вошли через токен!',
            'user' => $user->only(['id', 'login', 'name'])
        ]);
    }
}
