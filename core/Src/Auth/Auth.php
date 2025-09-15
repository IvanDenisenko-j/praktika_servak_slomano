<?php

namespace Src\Auth;

use Src\Session;

class Auth
{
    //Свойство для хранения любого класса, реализующего интерфейс IdentityInterface
    private static IdentityInterface $user;

    //Инициализация класса пользователя
    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    //Вход пользователя по модели
    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    //Аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    //Возврат текущего аутентифицированного пользователя
    public static function user()
    {
        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    //Проверка является ли текущий пользователь аутентифицированным
    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    //Выход текущего пользователя
    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5(time());
        Session::set('csrf_token', $token);
        return $token;
    }

    public function generateToken(int $userId): string
    {
        // Генерируем токен
        $token = bin2hex(random_bytes(60)); // 60 байт → 120 символов hex
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));

        // Сохраняем в БД
        Model\Token::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }

    public function checkByToken(string $token): ?\App\Model\User
    {
        $tokenRecord = Model\Token::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if ($tokenRecord) {
            return $tokenRecord->user; // Предположим, что есть связь `user()` в модели `Token`
        }

        return null;
    }

}