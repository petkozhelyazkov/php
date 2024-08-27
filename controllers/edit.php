<?php
class EditController extends Controller
{
    public function __construct()
    {
        $this->viewPath = './views/edit.php';
    }

    public function get(Request $req, Response $res): void
    {
        $db = new DB();
        $store = $db->getStore($req->args['id']);

        $res->view($this->viewPath, ['store' => $store]);
    }

    public function post(Request $req, Response $res): void
    {

        $db = new DB();
        $db->updateStore($req->args['id'], $_POST);

        $res->redirect('/');
    }

    public function put(Request $req, Response $res): void {}
    public function delete(Request $req, Response $res): void {}
}
