<?php

function isAuth($auth)
{
    return function ($req, $res) use ($auth) {
        if ($auth) {
            if (!$req->getSession('user')) {
                $res->redirect('/login');
            }
        } else {
            if ($req->getSession('user')) {
                $res->redirect('/');
            }
        }
    };
}
