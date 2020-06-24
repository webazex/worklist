<?php
spl_autoload_register(function ($class_name) {
    $str = $_SERVER['DOCUMENT_ROOT'].'/'.$class_name . '.php';
    $str = str_replace("\\", "/", $str);
    require_once ($str);
});
?>