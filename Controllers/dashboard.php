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
    if (empty($_POST['task_num-departament'])):
        $task_num_department = "";
    else:
        $task_num_department = $_POST['task_num-departament'];
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
        $folder_name = uniqid('t');
        $path = '/volume1/attaches/' . $folder_name;
        mkdir($path);
        foreach ($_FILES["task__attach"]['tmp_name'] as $k => $tmpFilePath):
            $tmp_name = $_FILES["task__attach"]["tmp_name"][$k];
            $name = $_FILES["task__attach"]["name"][$k];
            move_uploaded_file($tmpFilePath, $path . '/' . $name);
        endforeach;
        $data = array(
            'letter_num-moz' => $task_num_moz,
            'letter_num-ascod' => $task_num_askod,
            'letter_num-departament' => $task_num_department,
            'title' => $_POST['task__title'],
            'performers_departament' => $department_perfomance,
            'description' => $desc,
            'date_start' => $_POST['date-start'],
            'date_end' => $_POST['date-end'],
            'sender' => "",
            'recipient' => "",
            'performers' => $users,
            'status' => "В роботі",
            'folder' => $folder_name
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
//===end add task
function getTaskForUser($like)
{
    $tasks = getArrTasksForUser($like);
    return $tasks;
}

function getTasksForKanc($role)
{
    if ($role == 1):
        $tasks = getTasksForManagers();
        return $tasks;
    endif;
}

function getUsers($str)
{
    $ar = explode(",", $str);
    $rezult = getUsersList($ar);
    return $rezult;
}

function renderManagerTaskList($tasks)
{
    $rows = '';
    foreach ($tasks as $task):
        $ar = explode(",", $task[11]);
        $folder = $task[13];
        $arIds = array();
        foreach ($ar as $a):
            $a = preg_replace("/\"/", " ", $a);
            array_push($arIds, $a);
        endforeach;
        $performersList = getUsersList($arIds);
        $names = implode(", ", $performersList);
        $rows .= '<form class="table__row" id="tId-' . $task[0] . '" method="post" data-id="tId-' . $task[0] . '" action="" data-date-start="' . $task[7] . '" data-date-end="' . $task[8] . '">
<input class="row__col-date-start" type="text" name="date-start" value="' . $task[7] . '">
        <input class="row__col-task-title" type="text" name="title" value="' . $task[4] . '" readonly="readonly">
        <div class="numbers-task">
         <input class="row__col-task-moz" type="text" name="moz" value="' . $task[1] . '" readonly="readonly">
        <input class="row__col-task-ascod" type="text" name="ascod" value="' . $task[2] . '" readonly="readonly">
        <input class="row__col-task-department" type="text" name="department" value="' . $task[3] . '" readonly="readonly">
</div>
        <input class="row__col-task-department-performers" type="text" name="department-performers" value="' . $task[5] . '" readonly="readonly">
        <input class="row__col-task-performers" type="text" name="performers" value="' . $names . '" readonly="readonly">
        <input class="row__col-task-date-end" type="text" name="date-end" value="' . $task[8] . '">
        <input class="row__col-sender" type="text" name="sender" value="' . $task[9] . '">
        <input class="row__col-receiver" type="text" name="recipient" value="' . $task[10] . '">


       <select class="row__col-status"  name="status">
       <option selected="selected" value="0"<span>В роботі</span></option>
       <option value="1"><span>Виконано</span></option>
</select>
        <textarea name="desc" class="row__desc-row" readonly="readonly">' . $task[6] . '</textarea>
        <div class="row__attach-row">
        <a href="worklist://\\\10.168.5.201\\attaches\\' . $folder . '" class="attach-row__link"><span>Вкладення</span></a>
        <span class="attach-row__status-attach">Yes \ No</span>
</div>
        <div class="row__btns-row">
        <button type="submit" name="edittask" id="edit_task">Зберегти зміни</button>
        <button type="reset" class="reset-btn">Відміна</button>
</div>

    </form>';
    endforeach;
    echo $rows;
}

if ((empty($_POST['search-start-date']) and empty($_POST['search-end-date']))):

else:
    if (($_POST['search-start-date'] !== "" and ($_POST['search-end-date'] !== ""))):
        $tasks = getSearchIntervalDate($_POST['search-start-date'], $_POST['search-end-date']);
    endif;
    if ($_POST['search-start-date'] == ""):
        if ($_POST['search-end-date'] !== ""):
            $tasks = getSearchBeforeDate($_POST['search-end-date']);
        endif;
    endif;
    if ($_POST['search-end-date'] == ""):
        if ($_POST['search-start-date'] !== ""):
            $tasks = getSearchAfterDate($_POST['search-start-date']);
        endif;
    endif;
    renderManagerTaskList($tasks);
endif;

//search title
if (empty($_POST['search-theme'])):

else:
    $tasks = getSearchTitle($_POST['search-theme']);
    renderManagerTaskList($tasks);
endif;
//=====search for numbers tasks
if ((empty($_POST['search-moz']) and empty($_POST['search-ascod']) and empty($_POST['search-department']))):
else:
    $ar = $_POST;
    $tasks = array();
    foreach ($ar as $k => $v):
        if ($v !== ""):
            switch ($k):
                case "search-moz":
                    $field = "letter_num-moz";
                    break;
                case "search-ascod":
                    $field = "letter_num-ascod";
                    break;
                case "search-department":
                    $field = "letter_num-departament";
                    break;
            endswitch;
            $tasks = getSearchNumbers($field, $v);
        endif;
    endforeach;
    renderManagerTaskList($tasks);
endif;

//===search for performers
if (empty($_POST['search-performers'])):
    else:
    if ($_POST['search-performers'] !== "default"):
        $tasks = getSearchPerformers($_POST['search-performers']);
        renderManagerTaskList($tasks);
    endif;
endif;