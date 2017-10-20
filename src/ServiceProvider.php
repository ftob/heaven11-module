<?php
namespace Heaven11\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Heaven11\Client\Services\ClientService;
use Heaven11\Client\Services\Contracts\RequesterInterface;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider
 * @package AdIntelligence\Client
 */
class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Resources/config/parameters.php', 'heaven11'
        );

        $this->app->bind(ClientInterface::class, function ($app) {
            return new Client();
        });



        $this->app->bind(RequesterInterface::class, function($app) {
            return new ClientService(
                $this->app->make(ClientInterface::class),
                config('heaven11.server')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Resources/config/parameters.php' => config_path('heaven11.php'),
        ]);


    }
}