<?php

class CreateController extends Controller
{
    public function __construct()
    {
        $this->viewPath = './views/create.php';
    }
    public  function get(Request $req, Response $res): void
    {
        $res->view($this->viewPath);
    }

    public  function post(Request $req, Response $res): void
    {
        $db = new DB();
        $db->addStore($req->body);

        $res->redirect('/');
    }
    public  function put(Request $req, Response $res): void {}
    public  function delete(Request $req, Response $res): void {}
}
