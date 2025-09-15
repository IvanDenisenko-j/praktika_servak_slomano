<?php

namespace Providers;

use Src\Provider\AbstractProvider;
use Src\Route;

class AuthProvider extends AbstractProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        $authClass = $this->app->settings->getAuthClassName();
        $identityClass = $this->app->settings->getIdentityClassName();

        $authClass::init(new $identityClass);
        $this->app->bind('auth', new $authClass);
    }
}