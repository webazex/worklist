<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');
use Core\Classes\DB as bd;
function verify($login, $password, $role)
{
    $role = "'".$role."'";
    $r = bd::db_get_custom_fields_with_filter('roles', 'code_role', 'role', $role);
    $code = $r[0][0];
    $query = bd::db_select_in_user_table($login, $password, $code);
    if (empty($query)):
        return false;
    else:
        $userData = array();
        foreach ($query as $item):
            $userData['id'] = $item[0];
            $userData['fio'] = $item[1];
            $userData['login'] = $item[2];
            $userData['role'] = $item[3];
        endforeach;
        return $userData;
    endif;
}