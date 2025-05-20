<?php

namespace Src;

use Error;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    private Settings $settings;
    private Route $route;
    private Capsule $dbManager;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
        $this->route = new Route();
        $this->dbManager = new Capsule();
    }

    public function __get($key)
    {
        if ($key === 'settings') {
            return $this->settings;
        }
        throw new Error('Accessing a non-existent property');
    }

    private function dbRun()
    {
        $this->dbManager->addConnection($this->settings->getDbSetting());
        $this->dbManager->setEventDispatcher(new Dispatcher(new Container));
        $this->dbManager->setAsGlobal();
        $this->dbManager->bootEloquent();
    }

    public function run(): void
    {
        $this->dbRun();
        $this->route->setPrefix($this->settings->getRootPath());
        $this->route->start();
    }
}