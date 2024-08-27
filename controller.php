<?php
abstract class Controller
{
    protected string $viewPath;

    public abstract function get(Request $req, Response $res): void;
    public abstract function post(Request $req, Response $res): void;
    public abstract function put(Request $req, Response $res): void;
    public abstract function delete(Request $req, Response $res): void;
}
