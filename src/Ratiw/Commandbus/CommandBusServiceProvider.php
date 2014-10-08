<?php namespace Ratiw\CommandBus;

use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommandTranslator();

        $this->registerCommandBus();

        //$this->registerArtisanCommand();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['commandbus'];
    }

    /**
     * Register the command translator binding.
     */
    private function registerCommandTranslator()
    {
        $this->app->bind('Ratiw\CommandBus\CommandTranslator', 'Ratiw\CommandBus\BasicCommandTranslator');
    }

    /**
     * Register the command bus implementation.
     */
    private function registerCommandBus()
    {
        $this->app->bindShared('Ratiw\CommandBus\CommandBus', function($app)
        {
            return $app->make('Ratiw\CommandBus\DefaultCommandBus');
        });
    }
}