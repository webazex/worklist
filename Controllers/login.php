<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');
use Core\App as base;
base::getModel(__FILE__);
if((empty($_POST['login'])) or (empty($_POST['psw']))):
    echo "Відсутні авторизаційні дані";
else:
    $user = verify($_POST['login'], $_POST['psw'], $_POST['role']);
    if($user == false):
        echo "Некоректні логін, пароль, або посада";
    else:
    $_SESSION['id'] = $user['id'];
    $key = 'user_'.$user['id'];
    $_SESSION[$key] = $user;
    setcookie("user_id", $user['id']);
    unset($user);
    echo 1;
    endif;
endif;