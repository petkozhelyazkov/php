<?php
function dd($val)
{
    echo '<pre>';
    var_dump($val);
    echo '</pre>';
    die();
}

function splitPath($path)
{
    return explode('/', $path);
}
