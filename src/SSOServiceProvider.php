<?php

namespace Dudyali\SsoBappenasLib;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SSOServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public $customRoutesFilePath = '/routes/sso/sso_routes.php';

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->setupCustomRoutes($this->app->router);
        $this->publishFiles();
    }

    public function setupCustomRoutes(Router $router)
    {
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
    }

    /**
     * Publish files.
     *
     * @return void
     */
    public function publishFiles()
    {
        $custom_routes_file = [__DIR__.$this->customRoutesFilePath => base_path($this->customRoutesFilePath)];
        $config_files = [__DIR__.'/config' => config_path()];
        $minimum = array_merge(
            $custom_routes_file,
            $config_files,
        );
        $this->publishes($custom_routes_file, 'custom_routes');
        $this->publishes($config_files, 'config');
        $this->publishes($minimum, 'minimum');
    }
}
