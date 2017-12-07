<?php
	declare(strict_types=1);

	namespace Jkirkby91\IlluminateRequestPSR7Adapter\Middleware {

		use Closure;

		use Symfony\{
			Component\HttpFoundation\Response
		};

		use Zend\{
			Diactoros\Stream,
			Diactoros\ServerRequest
		};
		
		use Illuminate\{
			Http\Request
		};

		/**
		 * Class PSR7AdapterMiddleware
		 *
		 * @package Jkirkby91\IlluminateRequestPSR7Adapter\Middleware
		 * @author  James Kirkby <jkirkby@protonmail.ch>
		 */
		class PSR7AdapterMiddleware
		{

			/**
			 * handle()
			 * @param \Illuminate\Http\Request $request
			 * @param \Closure                 $next
			 *
			 * @return \Symfony\Component\HttpFoundation\Response
			 */
			public function handle(Request $request, Closure $next) : Response
			{
				//get source
				$currentContentIsResource = is_resource($request->getContent());

				//handle resources differently
				if ($currentContentIsResource == true) {
					rewind($request->getContent());
					$body = new Stream($request->getContent());
					$parsedBody = null;
				} else {
					$parsedBody = $request->all();
					$body = 'php://input';
				}

				//get other meta information
				$parameterBag   = $request->server();
				$uploadFiles    = $request->files->all();
				$uri            = $request->getUri();
				$method         = $request->getMethod();
				$headers        = $request->headers->all();
				$cookies        = $request->cookies->all();
				$queryParams    = $request->query->all();

				//get the psr7 request
				$PSR7Request = new ServerRequest($parameterBag,$uploadFiles,$uri,$method,$body,$headers,$cookies,$queryParams,$parsedBody);

				return $next($PSR7Request);
			}
		}
	}
