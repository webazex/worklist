<?php
namespace Core;
require_once($_SERVER['DOCUMENT_ROOT'].'/Core/autoload.php');
use Core\Classes\DB;
use Core\Route\Route as Routs;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
class App{
        function __construct(){
            spl_autoload_register(function ($class_name) {
                $str = $_SERVER['DOCUMENT_ROOT'].'/'.$class_name . '.php';
                $str = str_replace("\\", "/", $str);
                require_once ($str);
            });
            self::InitDB();
            self::InitRouting();
            // self::test();
        }
        static function Status_visitor(){
            if(isset($_SESSION['id'])):
                return true;
            else:
                return false;
            endif;

        }
        static function InitRouting(){
            $route = new Routs;
            return $route;
        }
        static function InitDB(){
            $db = new DB;
            return $db;
        }
        static function getView($view){
            $r = Routs::base_path_route();
            $str = $r['views'].$view.'.php';
            return $str;
        }
        static function getModel($models){
            $base = Routs::base_path_route();
            $model_name = basename($models, ".php");
            $path_to_model = $base['models'].$model_name.".php";
            require_once $path_to_model;
//            return $path_to_model;
        }
        static function getController($path_to_view){
            $base = Routs::base_path_route();
            $controller_name = basename($path_to_view, ".php");
            $path_to_controller = $base['controllers'].$controller_name.".php";
            require_once $path_to_controller;
//            return $path_to_controller;
        }
        static function getCurrentDate(){
            $date = date('Y')."-".date('m')."-".date('d');
//            $date = date('d').'-'.date('m').date('Y');
            echo($date);
        }
    }
    
?>