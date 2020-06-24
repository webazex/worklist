<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');

use Core\App as base;

base::getModel(__FILE__);
if (empty($_POST)):
    die("Помилка отримання данних");
endif;
if (isset($_POST['login'])):
    $reg = regUser();
    if(is_string($reg)):
        echo $reg;
    endif;
    if(is_bool($reg)):
        if($reg === true):
            echo "ok";
        else:
            echo $reg['text'];
        endif;
    endif;
else:
    echo "Дані відсутні";
endif;

