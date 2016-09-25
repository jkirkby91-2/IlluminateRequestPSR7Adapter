<?php

namespace Jkirkby91\IlluminateRequestPSR7Adapter\Middleware;

use Closure;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Zend\Diactoros\Stream;
use Illuminate\Http\Request;
use Zend\Diactoros\ServerRequest;

/**
 * Class PSR7AdapterMiddleware
 *
 * Converts Illuminate\Http\Request to Zend\Diactoros\ServerRequest which implements Psr\Http\Message\ServerRequestInterface
 *
 * @package Jkirkby91\IlluminateRequestPSR7Adapter
 * @author James Kirkby <jkirkby91@gmail.com>
 */
class PSR7AdapterMiddleware
{
    /**
     * Get that proprietary incoming request and make it standardised
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
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
