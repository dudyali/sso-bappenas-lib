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
    public $customRoutesFilePath = '/routes/sso_routes.php';
    public $webRoute = '/routes/web.php';
    public $commandPath = '/commands/AddSsoRoutesToWeb.php';
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
        $this->publishFiles($this->app->router);
    }

    public function setupCustomRoutes(Router $router)
    {
        // if the custom routes file is published, register its routes
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
    }

    public function updateRouteWeb(){
        $webFilePath = base_path($this->webRoute);
        $content = file_get_contents($webFilePath);
        $content .= "\n" . 'require __DIR__."/sso_routes.php";';
        file_put_contents($webFilePath, $content);
    }
    public function publishFiles()
    {
        $custom_routes_file = [__DIR__.$this->customRoutesFilePath => base_path($this->customRoutesFilePath)];
        $config_files       = [__DIR__.'/config' => config_path()];
        $command_files      = [__DIR__.'/commands' => base_path('app/Console/Commands')];
        $minimum = array_merge(
            $custom_routes_file,
            $config_files,
            $command_files,
        );
        $this->publishes($config_files, 'config');
        $this->publishes($command_files, 'commands');
        $this->publishes($minimum, 'minimum');
        $this->publishes($custom_routes_file, 'custom_routes',function () {
            $this->updateRouteWeb();
        });
        // $this->updateRouteWeb();
    }
}

?>