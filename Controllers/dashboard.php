<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');

use Core\App as base;

base::getModel(__FILE__);
function getUserData()
{
    $id = $_SESSION['id'];
    $k = 'user_' . $id;
    $user = $_SESSION[$k];
    return $user;
}

function getHiMessage()
{
    $mounts = date('F');
    switch ($mounts):
        case "December":
            $m = "Грудня";
            break;
        case "January":
            $m = "Січня";
            break;
        case "February":
            $m = "Лютого";
            break;
        case "March":
            $m = "Березня";
            break;
        case "April":
            $m = "Квітня";
            break;
        case "May":
            $m = "Травня";
            break;
        case "June":
            $m = "Червня";
            break;
        case "July":
            $m = "Липня";
            break;
        case "August":
            $m = "Серпня";
            break;
        case "September":
            $m = "Вересня";
            break;
        case "October":
            $m = "Жовтня";
            break;
        case "November":
            $m = "Листопада";
            break;
    endswitch;
    if ($mounts == "January"):
        $m = "Січня";
    endif;
    if ($mounts == "February"):
        $m = "Грудня";
    endif;
    if ($mounts == "March"):
        $m = "Березня";
    endif;
    if ($mounts == "April"):
        $m = "Квітня";
    endif;
    if ($mounts == "May"):
        $m = "Травня";
    endif;
    if ($mounts == "June"):
        $m = "Червня";
    endif;
    if ($mounts == "July"):
        $m = "Липня";
    endif;
    if ($mounts == "August"):
        $m = "Серпня";
    endif;
    if ($mounts == "September"):
        $m = "Вересня";
    endif;
    if ($mounts == "October"):
        $m = "Жовтня";
    endif;
    if ($mounts == "November"):
        $m = "Листопада";
    endif;
    if ($mounts == "December"):
        $m = "Грудня";
    endif;
    $name_day = date('l');

    if ($name_day == "Monday"):
        $text = "Понеділок";
    endif;
    if ($name_day == "Tuesday"):
        $text = "Вівторок";
    endif;
    if ($name_day == "Wednesday"):
        $text = "Середа";
    endif;
    if ($name_day == "Thursday"):
        $text = "Четверг";
    endif;
    if ($name_day == "Friday"):
        $text = "П’ятниця";
    endif;
    if ($name_day == "Saturday"):
        $text = "Субота";
    endif;
    if ($name_day == "Sunday"):
        $text = "Неділя";
    endif;
    $day = date('d');
    $year = date('Y');
    $h = date('H');
    $min = date('i');
    $fio = getUserData()['fio'];
    echo '<div class="hi-message">
            <span>Вітаю, ' . $fio . ' </span>
            <span class="date">
                Сьогодні:
                <span class="day">' . $text . '</span>
                <span class="day">' . $day . '</span>
                <span class="months">' . $m . '</span>
                <span class="year">' . $year . '</span>
                <span class="time-block">
                    <span class="h">' . $h . '</span> : <span class="minutes">' . $min . '</span>
                </span>
            </span>
        </div>';
}

if (isset($_POST['date'])):
    echo base::getCurrentDate();
endif;
function getLogout()
{
    echo '
        <div class="logout-block">
            <a href="/logout.php" class="logout-block__exit-btn" id="exit_btn"><span>Вихід</span></a>
        </div>
    ';
}

function getTemplate($name = null)
{

    if (getUserData()['role'] == 1):
        if (isset($name)):
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/templates/manager/' . $name . '.php');

        else:
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/templates/manager/manager.php');
        endif;
    elseif (getUserData()['role'] == 0):
        if (isset($name)):
            echo "Для виконавців поки що не передбачено додаткових можливостей, очікуйте оновленнь.";
        else:
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/templates/performer/performer.php');
        endif;
    elseif (getUserData()['role'] == 3):
        if (isset($name)):
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/templates/admin/' . $name . '.php');
        else:
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/templates/admin/admin.php');
        endif;
    endif;
}

function getListUsersNames()
{
    $names = getUsersName("OR");
    return $names;
}
//===add task
if (isset($_POST['addTask'])):
    $val = false;
    if (empty($_POST['department-perfomance'])):
        $department_perfomance = "";
    else:
        $department_perfomance = $_POST['department-perfomance'];
    endif;
    if (empty($_POST['task_num-department'])):
        $task_num_department = "";
    else:
        $task_num_department = $_POST['task_num-department'];
    endif;
    if (empty($_POST['task_num-askod'])):
        $task_num_askod = "";
    else:
        $task_num_askod = $_POST['task_num-askod'];
    endif;
    if (empty($_POST['task_num-moz'])):
        $task_num_moz = "";
    else:
        $task_num_moz = $_POST['task_num-moz'];
    endif;
    if (empty($_POST['task__desc'])):
        $desc = "";
    else:
        $desc = $_POST['task__desc'];
    endif;
    if (isset($_POST['users'])):
        $arrUsersId = array();
        foreach ($_POST['users'] as $userId):
            $item = '"' . $userId . '"';
            array_push($arrUsersId, $item);
        endforeach;
        $users = implode(",", $arrUsersId);
        $data = array(
            'letter_num-moz' => $task_num_moz,
            'letter_num-ascod' => $task_num_askod,
            'letter_num-departament' =>  $task_num_department,
            'title' => $_POST['task__title'],
            'performers_departament' => $department_perfomance,
            'description' => $desc,
            'date_start' => $_POST['date-start'],
            'date_end' => $_POST['date-end'],
            'sender' => "",
            'recipient' => "",
            'performers' => $users,
            'status' => "В роботі"
        );
        $send = implode(" ", $_POST['users']);
        $val = true;
    endif;
    if ($val === true):
        $send = addTaskInTable($data);
        if ($send === true):
            echo "ok";
        else:
            echo "false";
        endif;
    else:
        echo "zero";
    endif;
endif;
//===end task
function getTaskForUser($like)
{
    $tasks = getArrTasksForUser($like);
    return $tasks;
}
function getUsers($str){
    $ar = explode(",", $str);
    $rezult = getUsersList($ar);
    return $rezult;
}
