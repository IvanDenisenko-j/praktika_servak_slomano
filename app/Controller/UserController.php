<?php

namespace Controller;

use Src\Request;
use Src\Validator\Validator;
use Src\View;
use Model\User;
use Model\Role;

class UserController
{
    public function users(): string
    {
        $query = User::query()
            ->select(['users.*', 'roles.title as role_title'])
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id');

        // Фильтрация по роли
        if (!empty($_POST['role_id'])) {
            $query->where('role_id', $_POST['role_id']);
        }

        // Сортировка
        $sortColumns = [
            'id' => 'users.id',
            'email' => 'email',
            'role' => 'roles.title'
        ];

        if (!empty($_POST['sort_by']) && isset($sortColumns[$_POST['sort_by']])) {
            $query->orderBy($sortColumns[$_POST['sort_by']]);
        }

        $users = $query->get();

        return new View('site.users', [
            'users' => $users,
            'roles' => Role::all()
        ]);
    }

    public function addUserForm(): string
    {
        return new View('site.add_user', [
            'roles' => Role::all()
        ]);
    }

    public function addUser(Request $request): string
    {
        // Валидация обязательных полей
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'role_id' => ['required']
        ], [
            'required' => 'Поле :field пусто',
            'unique' => 'Поле :field должно быть уникально',
            'email' => 'Email должен соответствовать формату'
        ]);

        if($validator->fails()){
            return new View('site.add_user',
                ['roles' => Role::all(),
                 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
        }

        // Создание пользователя
        User::create([
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'name' => $_POST['name'],
            'role_id' => $_POST['role_id'],
        ]);

        return $this->users();
    }
}