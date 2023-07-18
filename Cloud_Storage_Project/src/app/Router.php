<?php

namespace App;

use App\Exception\RouteNotFoundException;

class Router
{
    private array $routes = [];
    private string $currentRequestMethod;
    private string $currentRoute;
    private array $patterns = [];

    private array $uriParams = [];

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        $this->currentRequestMethod = $requestMethod;
        $this->currentRoute = $route;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function put(string $route, callable|array $action): self
    {
        return $this->register('put', $route, $action);
    }

    public function delete(string $route, callable|array $action): self
    {
        return $this->register('delete', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];

        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            $action = $this->getAction($requestUri, $requestMethod);
            if (! $action) {
                throw new RouteNotFoundException();
            }
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], $this->uriParams);
                }
            }
        }

        throw new RouteNotFoundException();
    }

    /**
     * Takes array with patterns
     * Use placeholders from uri as a key and pattern as a value
     * Or add an empty array then will be used a default pattern '[^/]+'
     * @example location /book/{id}/{page} => ['id' => '\d+', 'page' => '\d*']
     * @param array $patterns
     */
    public function addPatterns(array $patterns): self
    {
        $this->patterns[$this->currentRequestMethod][$this->currentRoute] = $patterns;

        return $this;
    }

    private function getAction(string $requestUri, string $requestMethod)
    {
        $uriPatterns = $this->patterns[$requestMethod] ?? [];
        $action = null;
        foreach ($uriPatterns as $uri => $patterns) {
            $uriParts = explode('/', trim($uri, '/'));

            $uriKeys = array_map(fn($part) => trim($part, '{}'), array_filter(
                $uriParts,
                fn($part) => str_starts_with($part, '{')
            ));

            $patternUri = array_map(function ($part) use ($patterns) {
                if (! str_starts_with($part, '{')) {
                    return $part;
                }
                return '(' . $patterns[trim($part, '{}')] . ')' ?? '([^/]+)';
            }, $uriParts);

            $stringPatternUri = '#^/' . implode('/', $patternUri) . '$#';

            if (preg_match($stringPatternUri, $requestUri, $matches)) {
                $this->uriParams = array_combine($uriKeys, array_slice($matches, 1));
                $action = $this->routes[$requestMethod][$uri];

                break;
            }
        }
        return $action;
    }
}
