<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Core/autoload.php');
use Core\Route\Route as Route;
$path = $_SERVER['REQUEST_URI'];
Route::base_url_route($path);
