<?php

//Подключение автозагрузчика composer
require_once __DIR__ . '/../vendor/autoload.php';

//Создание экземпляра приложения
$app = new Src\Application(require __DIR__ . '/../config/app.php');

//Подключение хелперов
require_once __DIR__ .  '/../core/helpers.php';

return $app;