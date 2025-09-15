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
    public function index(): void
    {
        $posts = Post::all()->toArray();

        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function api_register(Request $request): string
    {
        $data = $request->all();

        $validator = new Validator($data, [
            'login' => ['required', 'unique:users,login'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            return json_encode(['errors' => $validator->errors()]);
        }

        $user = User::create([
            'login' => $data['login'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'name' => $data['name'] ?? '',
            'lastName' => $data['lastName'] ?? ''
        ]);

        if ($user) {
            $token = Auth::generateToken($user->id);
            return json_encode([
                'message' => 'Пользователь зарегистрирован',
                'token' => $token
            ]);
        }

        return json_encode(['error' => 'Не удалось создать пользователя']);
    }

    public function api_login(Request $request): string
    {
        $credentials = $request->all();

        if (!$user = Auth::attempt($credentials)) {
            return json_encode(['error' => 'Неправильный логин или пароль']);
        }

        $token = Auth::generateToken($user->id);

        return json_encode([
            'message' => 'Авторизация успешна',
            'token' => $token,
            'user' => $user->only(['id', 'login', 'name', 'lastName'])
        ]);
    }


    public function secure_data(Request $request): string
    {
        $user = $request->get('user'); // Получаем из запроса текущего пользователя

        return json_encode([
            'message' => 'Вы успешно вошли через токен!',
            'user' => $user->only(['id', 'login', 'name', 'lastName'])
        ]);
    }
}