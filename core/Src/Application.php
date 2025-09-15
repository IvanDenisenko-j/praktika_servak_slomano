<?php

namespace Src;

use Error;

class Application
{
    //Список провайдеров приложения
    private array $providers = [];
    //Данные приложения
    private array $binds = [];

    public function __construct(array $settings = [])
    {
        $this->addProviders($settings['providers']??[]);
        $this->registerProviders();
        $this->bootProviders();
    }

    //Заполнения списка провайдеров из массива
    public function addProviders(array $providers): void
    {
        foreach ($providers as $key => $class) {
            $this->providers[$key] = new $class($this);
        }
    }

    //Запуск методов register() у всех провайдеров
    private function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->register();
        }
    }

    //Запуск методов bootProviders() у всех провайдеров
    private function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot();
        }
    }

    //Публичный метод для добавления данных в приложение
    public function bind(string $key, $value): void
    {
        $this->binds[$key] = $value;
    }

    //Доступ к внутренним данным извне
    public function __get($key)
    {
        if (array_key_exists($key, $this->binds)) {
            return $this->binds[$key];
        }
        throw new Error('Accessing a non-existent property in application');
    }

    public function run(): void
    {
        //Запуск маршрутизации
        $this->route->start();
    }
}