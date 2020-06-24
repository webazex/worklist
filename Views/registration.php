<?php
session_start();
use Core\App as App;
if(App::Status_visitor()):
    header("location:/dashboard");
endif;
//Зание - сила, скрой его
?>
<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Sources/main.css">
</head>
<body>
<div class="site-size">
    <main>
        <div class="registration__content">
            <form class="content__reg-form" method="post" id="r_form" action="">
                <h3 class="reg-form__title"><span>реєстрація</span></h3>
                <input type="text" name="fio" placeholder="Прізвище ім’я">
                <input type="text" name="login" placeholder="Логін">
                <input type="password" name="psw" id="p1" placeholder="Пароль">
                <input type="password" name="psw2" id="p2"placeholder="Пароль ще раз">
                <select class="reg-form__select" name="role">
                    <option value="Керівник відділу"><span>Керівник відділу</span></option>
                    <option value="Канцелярія"><span>Канцелярія</span></option>
                </select>
                <div class="reg-form__btns-row">
                    <button type="submit" id="s_btn" class="btns-row__submit"><span>реєстрація</span></button>
                    <button type="reset" id="r_btn" class="btns-row__reset"><span>відміна</span></button>
                </div>
            </form>
            <div class="rezult" id="rezult"></div>
        </div>
    </main>
</div>
<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="/Sources/main.js"></script>
</body>
</html>