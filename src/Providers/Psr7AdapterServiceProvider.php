<?php

namespace Jkirkby91\IlluminateRequestPSR7Adapter\Providers;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LumenCorsServiceProvider
 *
 * @package Jkirkby91\LumenRestServerComponent\Providers
 * @author James Kirkby <jkirkby91@gmail.com>
 */
class Psr7AdapterServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @TODO get our psr7 implementation from config
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'ServerRequestInterface',
            'ServerRequest'
        );

        $this->app->bind(
            'ResponseInterface',
            'Response'
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