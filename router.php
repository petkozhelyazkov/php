<?php
class Request
{
    public $body = [];
    public $args = [];

    public function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public function removeSession($key)
    {
        unset($_SESSION[$key]);
    }
}

class Response
{
    public function redirect($path): void
    {
        header("Location: " . $path);
    }

    public function view($path, $varArr = [])
    {
        foreach ($varArr as $key => $vars) {
            ${$key} = $vars;
        }

        include $path;
    }
}

class Router
{
    private Request $req;
    private Response $res;

    public function __construct()
    {
        $this->req = new Request();
        $this->res = new Response();
    }

    private $handlers = [];
    private $controllers = [];
    private $middlewares = [
        'handlers' => [],
        'controllers' => []
    ];

    public function listen()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $this->req->body = $_REQUEST;

        $handler = $this->find($uri, $method);
        $controller = $this->find($uri);
        $handlerMiddleware = $this->find($uri, $method, true);
        $controllerMiddleware = $this->find($uri, '', true);

        if ($handler) {
            if ($handlerMiddleware) $handlerMiddleware($this->req, $this->res);
            $handler($this->req, $this->res);
        }
        if ($controller) {
            if ($controllerMiddleware) $controllerMiddleware($this->req, $this->res);

            match ($method) {
                'GET' => $controller->get($this->req, $this->res),
                'POST' => $controller->post($this->req, $this->res),
                'PUT' => $controller->put($this->req, $this->res),
                'DELETE' => $controller->delete($this->req, $this->res)
            };
        }
    }

    public function use($path, Controller $controller, $middleware = null)
    {
        $this->controllers[$path] = $controller;
        if ($middleware) {
            $this->middlewares['controllers'][$path] = $middleware;
        }
    }

    public function get($path, $handler, $middleware = null)
    {
        $this->handlers['GET'][$path] = $handler;
        if ($middleware) {
            $this->middlewares['handlers']['GET'][$path] = $middleware;
        }
    }

    public function post($path, $handler, $middleware = null): void
    {
        $this->handlers['POST'][$path] = $handler;
        if ($middleware) {
            $this->middlewares['handlers']['POST'][$path] = $middleware;
        }
    }


    private function find($uri, $method = '', $isMiddleware = false)
    {
        $handler = null;
        if ($method != '') {
            if ($isMiddleware) {
                if (!array_key_exists($method, $this->middlewares['handlers'])) return null;
                $handlers = $this->middlewares['handlers'][$method];
            } else {
                if (!array_key_exists($method, $this->handlers)) return null;
                $handlers = $this->handlers[$method];
            }
        } else {
            if ($isMiddleware) {
                $handlers = $this->middlewares['controllers'];
            } else {
                $handlers = $this->controllers;
            }
        }
        $uriParts = splitPath($uri);


        foreach ($handlers as $path => $handler) {
            $pathParts = splitPath($path);
            $args = [];
            $isCurrPath = true;

            if (count($uriParts) != count($pathParts)) continue;

            for ($i = 0; $i < count($pathParts); $i++) {

                if (str_contains($pathParts[$i], ':')) {

                    $args[substr($pathParts[$i], 1)] = $uriParts[$i];
                    continue;
                }

                if ($pathParts[$i] != $uriParts[$i]) {
                    $isCurrPath = false;
                    break;
                }
            }

            if ($isCurrPath) {
                if (count($args) > 0) {
                    $this->req->args = $args;
                }

                return $handler;
            }
        }

        return null;
    }
}
