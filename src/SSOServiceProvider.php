<?php
// packages/vendor-name/package-name/src/YourServiceProvider.php

namespace Dudyali\SsoBappenasLib;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
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
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->setupCustomRoutes($this->app->router);
        $this->publishFiles();
    }

    public function setupCustomRoutes(Router $router)
    {
        // if the custom routes file is published, register its routes
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
    }

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

?>