<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');

use Core\Classes\DB as bd;

function getUsersName($relation = "")
{
    switch ($relation):
        case "OR":
            $relation = "OR";
            break;
        case "AND":
            $relation = "AND";
            break;
        default:
            $relation = "AND";
    endswitch;
    $rezult = bd::db_get_custom_fields_with_filters($relation);
    return $rezult;
}

;
function addTaskInTable($arr)
{
    $add = bd::db_add_in_table('tasks', $arr);
    return $add;
}

function getArrTasksForUser($like)
{
    $tasks = bd::db_get_rows_for_user($like);
    return $tasks;
}

function getUsersList($ar = array()){
    $rezult = bd::db_get_users($ar);
    return $rezult;
}