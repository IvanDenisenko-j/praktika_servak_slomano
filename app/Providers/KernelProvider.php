<?php

namespace Providers;

use Src\Provider\AbstractProvider;
use Src\Settings;

class KernelProvider extends AbstractProvider
{
    private array $settings = [];

    public function register(): void
    {
        $this->settings = $this->getConfigs(__DIR__ . '/../../config');
    }

    public function boot(): void
    {
        $this->app->bind('settings', new Settings($this->settings));
    }

    //Функция, возвращающая массив всех настроек приложения
    private function getConfigs(string $path = ''): array
    {
        $settings = [];
        foreach (scandir($path) as $file) {
            $name = explode('.', $file)[0];
            if (!empty($name)) {
                $settings[$name] = include "$path/$file";
            }
        }
        return $settings;
    }
}