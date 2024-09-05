<?php

function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function abort($code = 404)
{
    http_response_code($code);
    require basePath("views/errors/$code.php");
    die();
}

function redirect($path)
{
    header("Location:/$path");
    exit();
}

function basePath($path = '/'): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . $path;
}

function goBack(): void
{
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

//TODO: move to a Helper class next 4 functions
function isCurrent(string $link): bool
{
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

    if($uri === $link){
        return true;
    }
    
    $route = explode('/', $uri)[1];

    return $route === $link;
}

function setSidebarClass(string $link): string
{
    return isCurrent($link) ? 'active' : '';
}

function setAriaCurrent(string $link): string
{
    return isCurrent($link) ? 'page' : 'false';
}

function setNavClass(string $link): string
{
    return isCurrent($link) ? 'secondary' : 'white';
}