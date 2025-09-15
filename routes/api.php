<?php

use Src\Route;

Route::add('GET', '/', [Controller\Api::class, 'index']);
Route::add('POST', '/echo', [Controller\Api::class, 'echo']);

Route::add('POST', '/register', [Controller\Api::class, 'api_register']);
Route::add('POST', '/login', [Controller\Api::class, 'api_login']);
