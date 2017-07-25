<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

/**
 * A middleware that determines the response
 * format that is preferred by the client.
 */
class NegotiateContent
{
    /**
     * A list of response content types supported by the different routes.
     *
     * @var array
     */
    protected $availableContentTypesForPaths = [
        'assemblies' => [
            'application/json',
            'text/csv',
            'text/html',
            'text/xml',
        ],
        'assemblies/.+' => [
            'application/json',
            'text/csv',
            'text/html',
            'text/xml',
        ],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->initializeFormats($request);

        // Find what are the available media types for the current request.
        $availableTypes = $this->getAvailableTypes($request->path());

        $acceptedType = $request->prefers($availableTypes);

        // If we cannot provide the resource in any of the formats
        // that are accepted by the client, we abort the request.
        if (!$acceptedType) {
            abort(
                Response::HTTP_NOT_ACCEPTABLE,
                'The supported formats are: '.implode(', ', $availableTypes).'.'
            );
        }

        // Register the accepted format on the request object to make
        // this info available to subsequent code or middleware.
        $request->setRequestFormat(
            $request->getFormat($acceptedType)
        );

        return $next($request);
    }

    /**
     * Register supported formats that the Symfony request doesn’t know about.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    protected function initializeFormats($request)
    {
        $request->setFormat('csv', 'text/csv');
    }

    /**
     * Find what are the available media types for the current request.
     *
     * @param  string  $path  The path of the current request
     *
     * @return array
     */
    protected function getAvailableTypes($path)
    {
        $paths = array_reverse($this->availableContentTypesForPaths);

        foreach ($paths as $path => $availableContentTypes) {
            if (preg_match("!{$path}!", $path)) {
                return $availableContentTypes;
            }
        }

        return [];
    }
}
