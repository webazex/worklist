<?php

namespace Core\Route;

use Core\App as base;

require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');

class Route
{
    static function base_path_route()    {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $path = $_SERVER['REQUEST_URI'];
        return array(
            'views' => $root . '/Views/',
            'models' => $root . '/Models/',
            'controllers' => $root . '/Controllers/',
            'classes' => $root . '/Core/Classes/',
            'templates' => $root . '/Views/templates/',
        );
    }
    static function base_url_route($path)
    {
        switch ($path):
            case "/login":
                $v = base::getView('login');
                require_once ($v);
                break;
            case "/reg":
                $v = base::getView('registration');
                require($v);
                break;
            case "/dashboard":
                $v = base::getView('dashboard');
                require ($v);
                break;
            default:
                $v = base::getView('404');
                require($v);
        endswitch;

    }

}

?>