<?php
$users = getListUsersNames();
$list = '';
foreach ($users as $user):
    $list .= '<li class="list__item">
    <input type="checkbox" name="users[]" value="' . $user[0] . '"><span class="item__user-name">' . $user[1] . '</span></li>';
endforeach;
$key_for_hidden = mt_rand(3, 6);
$rows = '';
$tasks = getTaskForUser($_SESSION['id']);
$strId = "";
if (empty($tasks)):
    echo "zero-t";
else:
    foreach ($tasks as $task):
        $ar = explode(" ", $task[11]);
        $arIds = array();
        foreach ($ar as $a):
            $a = preg_replace("/\"/", " ", $a);
            array_push($arIds, $a);
        endforeach;
        $performersList = getUsersList($arIds);
        $names = implode(", ", $performersList);
        $rows .= '<form class="table__row" id="tId-' . $task[0] . '" method="post" data-id="tId-' . $task[0] . '" action="">
<input class="row__col-date-start" type="text" name="date-start" value="' . $task[7] . '">
        <input class="row__col-task-title" type="text" name="title" value="' . $task[4] . '" readonly="readonly">
        <input class="row__col-task-moz" type="text" name="moz" value="' . $task[1] . '" readonly="readonly">
        <input class="row__col-task-ascod" type="text" name="ascod" value="' . $task[2] . '" readonly="readonly">
        <input class="row__col-task-department" type="text" name="department" value="' . $task[3] . '" readonly="readonly">
        <input class="row__col-task-department-performers" type="text" name="department-performers" value="' . $task[5] . '" readonly="readonly">
        <input class="row__col-task-performers" type="text" name="performers" value="' . $names . '" readonly="readonly">
        <input class="row__col-task-date-end" type="text" name="date-end" value="' . $task[8] . '">
        <input class="row__col-sender" type="text" name="sender" value="' . $task[9] . '">
        <input class="row__col-receiver" type="text" name="recipient" value="' . $task[10] . '">
</div>
<div class="row__section-second">

        
       <select class="row__col-status"  name="status">
       <option selected="selected" value="0"<span>В роботі</span></option>
       <option value="1"><span>Виконано</span></option>
</select>
        <textarea name="desc" class="row__desc-row" readonly="readonly">' . $task[6] . '</textarea>
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
    <div class="tabs__tabs-rows">
        <div class="tabs-rows__item" id="1">
            <span>поставити задачі</span>
        </div>
        <div class="tabs-rows__item" id="2">
            <span>переглянути задачі</span>
        </div>
    </div>
    <div class="tabs__section-container">
        <div class="section-container__tabs-section" data-id="1">
            <form class="tabs-section__new-task-form" id="newTaskForm" method="post" action="">
                <div class="new-task-form__content">
                    <div class="content__list-users">
                    <h3>Вкажіть виконавця(-ів):</h3>
                     <ul class="list-users__list">' . $list . '                     
</ul>
<div class="form__btns-row">
                <button type="submit" class="btns-row__submit" id="task_submit"><span>Поставити задачу</span></button>
                 <button type="reset" class="btns-row__reset"><span>Очистити</span></button>
</div>
</div>
<div class="content__form">
<input type="text" name="task_num" class="task-num-departament"  placeholder="Вкажіть номер вхідного листа по департаменту">
<input type="text" name="task_num" class="task-num-askod" placeholder="Вкажіть номер вхідного листа по ASCOD">
<input type="text" name="task_num" class="task-num-moz"  placeholder="Вкажіть номер вхідного листа по МОЗ">
<label class="task-theme"><span>Вкажіть тему вхідного листа</span><input type="text" name="task__title" class="task-title" required="required"  placeholder="Не обов’язково"></label>
<label class="date-start"><span>Дата постановки задачі</span>
    <input type="date" name="date-start"  required="required" min="" max="">
</label>
<label class="date-end"><span>Кінцевий термін виконання</span>
    <input type="date" name="date-end"  required="required">
</label>


<textarea name="task__desc" class="textarea" placeholder="Вкажіть деталі вхідного листа (якщо потрібно)"></textarea>
<input type="hidden" name="addTask" value="' . $key_for_hidden . '">
                </div>
                </div>
            </form>
            <div class="callback" id="callback"></div>
        </div><div class="section-container__tabs-section" data-id="2">
        <div class="tabs-section__table"><div class="table__labels-row">
        <span class="labels-row__label">Дата постановки задачі</span>
        <span class="labels-row__label">Тема</span>
        <span class="labels-row__label">Номер вхідного по МОЗ</span>
        <span class="labels-row__label">Номер вхідного по ASCOD</span>
        <span class="labels-row__label">Виконавці по департаменту</span>
        <span class="labels-row__label">Номер вхідного по Департаменту</span>
        <span class="labels-row__label">Виконавці(-ець)</span>
        <span class="labels-row__label">Кінцева дата</span>
        <span class="labels-row__label">Відправник</span>
        <span class="labels-row__label">Куди відправлено</span>
        <span class="labels-row__label">Статус</span>
</div> ' . $rows . '

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
<!--<script src="/Sources/main.js"></script>-->