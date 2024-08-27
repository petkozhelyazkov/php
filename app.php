<?php
include './router.php';
include './controllers/home.php';
include './controllers/edit.php';
include './controllers/create.php';
include './controllers/login.php';
include './controllers/register.php';
include './middlewares/auth.php';

session_start();

$router = new Router();

$homeController = new HomeController();
$editController = new EditController();
$createController = new CreateController();
$loginController = new LoginController();
$registerController = new RegisterController();

$router->use('/', $homeController);
$router->use('/edit/:id', $editController, isAuth(true));
$router->use('/create', $createController, isAuth(true));

$router->use('/login', $loginController, isAuth(false));
$router->use('/register', $registerController, isAuth(false));

$router->get('/logout', function ($req, $res) {
    $req->removeSession('user');
    $res->redirect('/');
});

$router->listen();
