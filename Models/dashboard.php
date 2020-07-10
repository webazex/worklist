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
function getTasksForManagers(){
    $tasks = bd::db_read_all_table('tasks');
    return $tasks;
}
function getUsersList($ar = array()){
    $rezult = bd::db_get_users($ar);
    return $rezult;
}
function getSearchBeforeDate($date_limit){
    $search = bd::db_search_end_interval_date($date_limit);
    return $search;
}
function getSearchAfterDate($date_start){
    $search = bd::db_search_start_interval_date($date_start);
    return $search;
}
function getSearchIntervalDate($date_start, $date_limit){
    $search = bd::db_search_interval_date($date_start, $date_limit);
    return $search;
}
function getSearchTitle($title){
    $search = bd::db_search_title($title);
    return $search;
}
function getSearchNumbers($f, $v){
    $search = bd::db_search_numbers($f, $v);
    return $search;
}
function getSearchPerformers($v){
    $v = '"'.$v.'"';
    $search = bd::db_search_performers($v);
    return $search;
}
function getSearchDepartmentPerformers($v){
    $search = bd::db_search_department_performers($v);
    return $search;
}
function getSearchBeforeDateEnd($date_limit){
    $search = bd::db_search_end_interval_date_end($date_limit);
    return $search;
}
function getSearchAfterDateEnd($date_start){
    $search = bd::db_search_start_interval_date_end($date_start);
    return $search;
}
function getSearchIntervalDateEnd($date_start, $date_limit){
    $search = bd::db_search_interval_date_end($date_start, $date_limit);
    return $search;
}
//function getId($fio){
//    $arIds = bd::db_get_custom_fields_with_filter('id','users', 'fio', $fio);
//    return $arIds;
//}
function updateTask($id, $data){
    $query = bd::db_update_in_table('tasks', $data, $id);
    return $query;
}
