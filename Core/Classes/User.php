<?php

namespace Core\Classes;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');
use Core\App as App;
class User
{
    static function valid_user($id) {
        $valid = App::Status_visitor();
        if($valid === true):
            echo "auts";
        else:
            echo "non-auts";
        endif;
    }

}