<?php
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
$tasks = getTasksForKanc($_SESSION[$id]['role']);
$strId = "";
if (empty($tasks)):
    echo '<div class="panels__home-panels">
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
            <form class="tabs-section__new-task-form" id="newTaskForm" method="post" action="" enctype="multipart/form-data">
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
<input type="text" name="task_num-departament" class="task-num-departament"  placeholder="Вкажіть номер вхідного листа по департаменту">
<input type="text" name="task_num-askod" class="task-num-askod" placeholder="Вкажіть номер вхідного листа по ASCOD">
<input type="text" name="task_num-moz" class="task-num-moz"  placeholder="Вкажіть номер вхідного листа по МОЗ">
<label class="task-theme"><span>Вкажіть тему вхідного листа</span><input type="text" name="task__title" class="task-title"  placeholder="Не обов’язково"></label>
<label class="date-start"><span>Дата постановки задачі</span>
    <input type="date" name="date-start"  required="required" min="" max="">
</label>
<label class="date-end"><span>Кінцевий термін виконання</span>
    <input type="date" name="date-end"  required="required">
</label>

<textarea name="department-perfomance" class="department-perfomance" placeholder="Вкажіть виконавців департаменту (якщо потрібно)"></textarea>
<textarea name="task__desc" class="textarea" placeholder="Вкажіть деталі вхідного листа (якщо потрібно)"></textarea>
<input type="file" name="task__attach[]" class="task-num-file" multiple="multiple">
<input type="hidden" name="addTask" value="' . $key_for_hidden . '">
                </div>
                </div>
            </form>
            <div class="callback" id="callback"></div>
        </div>';
else:
    $rows = '';
    foreach ($tasks as $task):
        $ar = explode(",", $task[11]);
        $folder = $task[13];
        $status = $task[12];
        $sender = $task[9];
//            $list = array(
//                'економічний (econom.med.ks@ukr.net)', 'асу (medstat-kherson@ukr.net)',
//                'технічний відділ (to-oz@ukr.net)', 'Левко (medstat-centr@ukr.net)',
//                'Курдіна (tanya.kurdina@ukr.net)', 'ЕОЗ (e-health@ukr.net)',
//                'Канцелярія (kanc-medstat@ukr.net)'
//            );
        switch($sender):
            case "економічний (econom.med.ks@ukr.net)":
                $senderlist = '<option value="економічний (econom.med.ks@ukr.net)" default="default"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "асу (medstat-kherson@ukr.net)":
                $senderlist = '<option value="асу (medstat-kherson@ukr.net)" default="default"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "технічний відділ (to-oz@ukr.net)":
                $senderlist = '<option value="технічний відділ (to-oz@ukr.net)" default="default"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "Левко (medstat-centr@ukr.net)":
                $senderlist = '<option value="Левко (medstat-centr@ukr.net)" default="default"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "Курдіна (tanya.kurdina@ukr.net)":
                $senderlist = '<option value="Курдіна (tanya.kurdina@ukr.net)" default="default"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "ЕОЗ (e-health@ukr.net)":
                $senderlist = '<option value="ЕОЗ (e-health@ukr.net)" default="default"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
                break;
            case "Канцелярія (kanc-medstat@ukr.net)":
                $senderlist = '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                break;
            default:
                $senderlist = '<option value="" default="default"><span>Оберіть відділ</span></option>';
                $senderlist .= '<option value="асу (medstat-kherson@ukr.net)"><span>асу (medstat-kherson@ukr.net)</span></option>';
                $senderlist .= '<option value="економічний (econom.med.ks@ukr.net)"><span>економічний (econom.med.ks@ukr.net)</span></option>';
                $senderlist .= '<option value="технічний відділ (to-oz@ukr.net)"><span>технічний відділ (to-oz@ukr.net)</span></option>';
                $senderlist .= '<option value="Левко (medstat-centr@ukr.net)"><span>Левко (medstat-centr@ukr.net)</span></option>';
                $senderlist .= '<option value="Курдіна (tanya.kurdina@ukr.net)"><span>Курдіна (tanya.kurdina@ukr.net)</span></option>';
                $senderlist .= '<option value="ЕОЗ (e-health@ukr.net)"><span>ЕОЗ (e-health@ukr.net)</span></option>';
                $senderlist .= '<option value="Канцелярія (kanc-medstat@ukr.net)"><span>Канцелярія (kanc-medstat@ukr.net)</span></option>';
        endswitch;

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
<input class="row__col-date-start" type="text" name="date-start" value="' . $task[7] . '">
        <input class="row__col-task-title" type="text" name="title" value="' . $task[4] . '">
        <div class="numbers-task">
         <input class="row__col-task-moz" type="text" name="moz" value="' . $task[1] . '">
        <input class="row__col-task-ascod" type="text" name="ascod" value="' . $task[2] . '">
        <input class="row__col-task-department" type="text" name="department" value="' . $task[3] . '">
</div>
        <input class="row__col-task-department-performers" type="text" name="department-performers" value="' . $task[5] . '">
        <textarea class="row__col-task-performers" type="text" name="performers" readonly="readonly">' . $names . '</textarea>
        <input class="row__col-task-date-end" type="text" name="date-end" value="' . $task[8] . '">
        <select class="row__col-sender" type="text" name="sender">'.$senderlist.'</select>
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
            <form class="tabs-section__new-task-form" id="newTaskForm" method="post" action="" enctype="multipart/form-data">
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
<input type="text" name="task_num-departament" class="task-num-departament"  placeholder="Вкажіть номер вхідного листа по департаменту">
<input type="text" name="task_num-askod" class="task-num-askod" placeholder="Вкажіть номер вхідного листа по ASCOD">
<input type="text" name="task_num-moz" class="task-num-moz"  placeholder="Вкажіть номер вхідного листа по МОЗ">
<label class="task-theme"><span>Вкажіть тему вхідного листа</span><input type="text" name="task__title" class="task-title" required="required"  placeholder="Не обов’язково"></label>
<label class="date-start"><span>Дата постановки задачі</span>
    <input type="date" name="date-start"  required="required" min="" max="">
</label>
<label class="date-end"><span>Кінцевий термін виконання</span>
    <input type="date" name="date-end"  required="required">
</label>

<textarea name="department-perfomance" class="department-perfomance" placeholder="Вкажіть виконавців департаменту (якщо потрібно)"></textarea>
<textarea name="task__desc" class="textarea" placeholder="Вкажіть деталі вхідного листа (якщо потрібно)"></textarea>
<input type="file" name="task__attach[]" class="task-num-file" multiple="multiple" placeholder="Додайте файли (при необхідності)"></input>
<input type="hidden" name="addTask" value="' . $key_for_hidden . '">
                </div>
                </div>
            </form>
            <div class="callback" id="callback"></div>
        </div><div class="section-container__tabs-section" data-id="2">
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
        <form action="" id="sPerfomance" method="post">
        <select class="search-performers" name="search-performers">
        <option default value="default"><span>Оберіть виконавця</span></option>'.$options.'
</select>
        <button type="submit" id="subPerfomance">
            <span>Пошук</span>
            </button>
            <button type="reset" id="resPerfomance">
            <span>Відміна</span>
            </button>
        </form>
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
<!--<script src="/Sources/main.js"></script>-->