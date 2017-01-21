<?php

namespace Jkirkby91\IlluminateRequestPSR7Adapter\Providers;

use Zend\Diactoros;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LumenCorsServiceProvider
 *
 * @package Jkirkby91\LumenRestServerComponent\Providers
 * @author James Kirkby <jkirkby91@gmail.com>
 */
class IlluminateRequestPSR7AdapterServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Psr\Http\Message\ServerRequestInterface',
            'Zend\Diactoros\ServerRequest'
        );

        $this->app->bind(
            'Psr\Http\Message\ResponseInterface',
            'Zend\Diactoros\Response'
        );

        $this->registerMiddleware();

    }


    /**
     * Register any component middlewares
     */
    public function registerMiddleware()
    {
        $this->app->middleware(\Jkirkby91\IlluminateRequestPSR7Adapter\Middleware\PSR7AdapterMiddleware::class);
    }

}