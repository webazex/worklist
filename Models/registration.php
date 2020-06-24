<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');

use Core\Classes\DB as bd;

function checkLogin($login)
{
    $ar = array(
        'login' => $login,
        'passw' => '',
        'role' => ""
    );
    $check = bd::db_search_in_user_table($_POST['login'], 0);
    return $check;
}

function regUser()
{
    $check_login = checkLogin($_POST['login']);
    if (!empty($check_login)):
        echo "Даний логін вже існує";
    else:
        $allRoles = bd::db_select_in_table('roles', "`role`");
        $ar = array();
        foreach ($allRoles as $item):
            array_push($ar, $item[0]);
        endforeach;
        $has_role = array_search($_POST['role'], $ar);
        if ($has_role === false):
            return array(
                'status' => false,
                'text' => "Дана привілегія відсутня в списку доступних Вам привілеїв!"
            );
        else:
            $f = "`code_role`, `role`";
            $filter = "role";
            $filterV = "'" . $_POST['role'] . "'";
            $getRoleCode2 = bd::db_get_custom_fields_with_filter('roles', $f, $filter, $filterV);
            foreach ($getRoleCode2 as $item):
                $role = $item[0];
            endforeach;

            $data = array(
                'fio' => $_POST['fio'],
                'login' => $_POST['login'],
                'passw' => $_POST['psw'],
                'role' => $role
            );
            $add = bd::db_add_in_table('users', $data);
            return $add;
        endif;
    endif;
}
