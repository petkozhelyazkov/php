<?php
require './controller.php';
require './db.php';

class HomeController extends Controller
{
    public function __construct()
    {
        $this->viewPath = './views/home.php';
    }

    public function get(Request $req, Response $res): void
    {
        $db = new DB();
        $stores = $db->getStores();

        $res->view($this->viewPath, [
            'stores' => $stores,
            'user' => $req->getSession('user')
        ]);
    }
    public function post(Request $req, Response $res): void {}
    public function put(Request $req, Response $res): void {}
    public function delete(Request $req, Response $res): void {}
}
