<?php

use Src\Route;

Route::add(['GET','POST'], '/employees', [Controller\EmployeeController::class, 'employees'])->middleware('auth');
Route::add(['GET'], '/add-employee', [Controller\EmployeeController::class, 'addEmployeeForm'])->middleware('auth');
Route::add(['POST'], '/add-employee', [Controller\EmployeeController::class, 'addEmployee'])->middleware('auth');

Route::add(['GET','POST'], '/units', [Controller\UnitController::class, 'units'])->middleware('auth');
Route::add(['GET'], '/add-unit', [Controller\UnitController::class, 'addUnitForm'])->middleware('auth');
Route::add(['POST'], '/add-unit', [Controller\UnitController::class, 'addUnit'])->middleware('auth');

Route::add(['GET','POST'], '/users', [Controller\UserController::class, 'users'])->middleware('admin');
Route::add(['GET'], '/add-user', [Controller\UserController::class, 'addUserForm'])->middleware('admin');
Route::add(['POST'], '/add-user', [Controller\UserController::class, 'addUser'])->middleware('admin');

Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login'])->middleware('antiauth');
Route::add(['GET', 'POST'], '/', [Controller\AuthController::class, 'login'])->middleware('antiauth');
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);


