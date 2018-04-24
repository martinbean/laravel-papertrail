<?php

namespace MartinBean\LaravelPapertrail;

use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;

class LaravelPapertrailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/papertrail.php' => config_path('papertrail.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__.'/../config/papertrail.php'),
            'papertrail'
        );

        if ($this->isConfigured()) {
            $this->app['log']->extend('papertrail', function ($app) {
                $host = $app['config']['papertrail.host'];
                $port = $app['config']['papertrail.port'];

                $formatter = new LineFormatter('%channel%.%level_name%: %message% %context%');

                $handler = new SyslogUdpHandler($host, $port);
                $handler->setFormatter($formatter);

                return new Logger('papertrail', [
                    $handler,
                ]);
            });
        }
    }

    /**
     * Determine if the Papertrail configuration exists.
     *
     * @return bool
     */
    private function isConfigured(): bool
    {
        return $this->hostIsConfigured() && $this->portIsConfigured();
    }

    /**
     * Determine if the Papertrail host is configured.
     */
    private function hostIsConfigured(): bool
    {
        return ! is_null($this->app['config']['papertrail.host']);
    }

    /**
     * Determine if the Papertrail port is configured.
     *
     * @return bool
     */
    private function portIsConfigured(): bool
    {
        return (int) $this->app['config']['papertrail.port'] > 0;
    }
}
