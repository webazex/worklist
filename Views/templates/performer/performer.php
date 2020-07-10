<?php
//echo "22";
$users = getListUsersNames();
$list = '';
$options = '';
foreach ($users as $user):
    $list .= '<li class="list__item">
    <input type="checkbox" name="users[]" value="' . $user[0] . '"><span class="item__user-name">' . $user[1] . '</span></li>';
    $options .= '<option value="' .$user[0].'" <span>'.$user[1].'</span></option>';
endforeach;
$key_for_hidden = mt_rand(3, 6);
$rows = '';
//$tasks = getTaskForUser($_SESSION['id']);
$id = 'user_'.$_SESSION['id'];
$tasks = getTaskForUser($_SESSION[$id]['id']);
$strId = "";
if (empty($tasks)):
    echo '<div class="panels__home-panels">Задачі відсутні</div>
';
else:
    $rows = '';
    foreach ($tasks as $task):
        $ar = explode(",", $task[11]);
        $folder = $task[13];
        $status = $task[12];
        if($status == "В роботі"):
            $statusHtml = '<option selected="selected" value="0"<span>В роботі</span></option>
       <option value="1"><span>Виконано</span></option>';
        else:
            $statusHtml = '<option selected="selected" value="1"<span>Виконано</span></option>
       <option value="0"><span>В роботі</span></option>';
        endif;
        $arIds = array();
        foreach ($ar as $a):
            $a = preg_replace("/\"/", " ", $a);
            array_push($arIds, $a);
        endforeach;
        $performersList = getUsersList($arIds);
        $names = implode(", ", $performersList);
        $rows .= '<form class="table__row" id="tId-' . $task[0] . '" method="post" data-id="' . $task[0] . '" action="" data-date-start="' . $task[7] . '" data-date-end="' . $task[8] . '">
        <input type="hidden" name="taskId" value="' . $task[0] . '">
<input class="row__col-date-start" type="text" name="date-start" value="' . $task[7] . '" readonly="readonly">
        <input class="row__col-task-title" type="text" name="title" value="' . $task[4] . '" readonly="readonly">
        <div class="numbers-task">
         <input class="row__col-task-moz" type="text" name="moz" value="' . $task[1] . '" readonly="readonly">
        <input class="row__col-task-ascod" type="text" name="ascod" value="' . $task[2] . '" readonly="readonly">
        <input class="row__col-task-department" type="text" name="department" value="' . $task[3] . '" readonly="readonly">
</div>
        <input class="row__col-task-department-performers" type="text" name="department-performers" value="' . $task[5] . '" readonly="readonly">
        <textarea class="row__col-task-performers" type="text" name="performers" readonly="readonly">' . $names . '</textarea>
        <input class="row__col-task-date-end" type="text" name="date-end" value="' . $task[8] . '" readonly="readonly">
        <input class="row__col-sender" type="text" name="sender" value="' . $task[9] . '">
        <input class="row__col-receiver" type="text" name="recipient" value="' . $task[10] . '">
       <select class="row__col-status"  name="status">'.$statusHtml.'
      
       
</select>
        <textarea name="desc" class="row__desc-row">' . $task[6] . '</textarea>
        <div class="row__attach-row">
        <a href="worklist://\\\10.168.5.201\\attaches\\'.$folder.'" class="attach-row__link"><span>Вкладення</span></a>
        <span class="attach-row__status-attach">Yes \ No</span>
</div>
        <div class="row__btns-row">
        <button type="submit" name="edittask" id="edit_task">Зберегти зміни</button>
        <button type="reset" class="reset-btn">Відміна</button>
</div>

    </form>';

    endforeach;
    $html = '
<div class="panels__home-panels">
<div class="home-panels__tabs">
<div class="tabs__block" id="manager_tabs">
    <div class="tabs__section-container">
        <div class="section-container__tabs-section" data-id="2">
        <div class="tabs-section__table"><div class="table__labels-row">
        <div class="labels-row__label">
        <div class="label__data-block-label">
            <div class="label__text">
            <div class="text__row">
                <span class="row__txt">Дата постановки задачі</span>
                <span class="row__arrow"></span>
                </div>
            <div class="label__block-filter">
            <button type="button" class="block-filter__asc" id="start-date-asc">
                <img class="asc__img" src="/Sources/pic/asc.png">
                <span>За зростанням</span>
            </button>
            <button class="block-filter__desc" id="start-date-desc">
            <img class="desc__img" src="/Sources/pic/desc.png">
                <span>За спаданням</span>
</button>
</div>
            </div>
            <form action="" id="sDateStart" method="post">
            <input type="date" name="search-start-date">
            <input type="date" name="search-end-date">
            <button type="submit" id="subDateStart" name="searchDateStart">
            <span>Пошук</span>
            </button>
            <button type="button" id="clearDateStart" name="clearDateStart">
            <span>Відміна</span>
            </button>
            </form>
        </div>
        </div>
        <div class="labels-row__label">
        <span class="label__text">Тема</span>
        <form action="" id="sTheme" method="post">
        <input type="search" name="search-theme">
        <button type="submit" id="subTheme">
            <span>Пошук</span>
            </button>
             <button type="reset" id="resTheme">
            <span>Відміна</span>
            </button>
        </form>
        </div>
        <div class="labels-row__label numbers">
        <form id="sNumbers" method="post" action="">
        <div class="label__block-moz">
        <span class="labels-row__label">Номер вхідного по МОЗ</span>
        
        <input type="search" name="search-moz">
</div>
        <div class="label__block-ascod">
        <span class="labels-row__label">Номер вхідного по ASCOD</span>
        <input type="search" name="search-ascod">
</div>
        <div class="label__block-department">
        <span class="labels-row__label">Номер вхідного по Департаменту</span>
        <input type="search" name="search-department">
        <button type="submit" id="subNumbers">
            <span>Пошук</span>
            </button>
             <button type="reset" id="resNumbers">
            <span>Відміна</span>
            </button>
</div>
</form>
</div>       
        <div class="labels-row__label">
        <span class="label__text">Виконавці по департаменту</span>
        <form action="" id="sDepartmentPerfomance" method="post">
       <input type="search" name="search-department-perfomance">
        <button type="submit" id="subDepPerfomance">
            <span>Пошук</span>
            </button>
            <button type="reset" id="resDepPerfomance">
            <span>Відміна</span>
            </button>
        </form>
        </div>
        <div class="labels-row__label">
        <span class="label__text">Виконавці(-ець)</span>
        </div>
        <div class="labels-row__label">
            <div class="label__text">
            <div class="text__row">
                <span class="row__txt">Кінцева дата</span>
                <span class="row__arrow"></span>
                </div>
            <div class="label__block-filter">
            <button type="button" class="block-filter__asc" id="end-date-asc">
                <img class="asc__img" src="/Sources/pic/asc.png">
                <span>За зростанням</span>
            </button>
            <button class="block-filter__desc" id="end-date-desc">
            <img class="desc__img" src="/Sources/pic/desc.png">
                <span>За спаданням</span>
</button>
</div>
            </div>
            <form action="" id="sDateEnd" method="post">
             <input type="date" name="search-start-date-e">
            <input type="date" name="search-end-date-e">
            <button type="submit" id="subDateEnd">
            <span>Пошук</span>
            </button>
            <button type="reset" id="resDateEnd">
            <span>Відміна</span>
            </button>
</form>
           
        </div>
        <div class="labels-row__label">Відправник</div>
        <div class="labels-row__label">Куди відправлено</div>
        <div class="labels-row__label">
        <div class="label__text">
        <span>Статус</span>
        </div>      
</div></div> <div class="tasks-list">' .$rows. '</div>

</div>
</div>
        
    </div>
</div>
</div>
</div>
</div>
';
    echo $html;
endif;
?>