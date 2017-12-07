<?php
	declare(strict_types=1);

	namespace Jkirkby91\IlluminateRequestPSR7Adapter\Providers {

		use Jkirkby91\{
			IlluminateRequestPSR7Adapter\Middleware\PSR7AdapterMiddleware
		};

		use Zend\{
			Diactoros\Response,
			Diactoros\ServerRequest
		};

		use Illuminate\{
			Support\ServiceProvider
		};

		use Psr\{
			Http\Message\ResponseInterface,
			Http\Message\ServerRequestInterface
		};

		/**
		 * Class Psr7AdapterServiceProvider
		 *
		 * @package Jkirkby91\IlluminateRequestPSR7Adapter\Providers
		 * @author  James Kirkby <jkirkby@protonmail.ch>
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

				$this->app['psr7request'] = new ServerRequest;

				$this->registerMiddleware();
			}

			/**
			 * Register any component middlewares
			 */
			public function registerMiddleware()
			{
				$this->app->middleware(PSR7AdapterMiddleware::class);
				$this->app->routeMiddleware(['psr7adapter' => PSR7AdapterMiddleware::class]);
			}
		}
	}
