<?php
session_start();
use Core\App as App;
if(App::Status_visitor()):
    header("location:/dashboard");
endif;
//Лень ведет к ереси
?>
<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Sources/main.css">
</head>
<body>
<div class="site-size">
    <main>
        <div class="auth__content">
            <form class="content__auth-form" method="post" id="a_form" action="">
                <h3 class="auth-form__title"><span>авторизація</span></h3>
                <input type="text" name="login" placeholder="Логін">
                <input type="password" name="psw" id="p1" placeholder="Пароль">
                <select class="auth-form__select" name="role">
                    <option value="Керівник відділу"><span>Керівник відділу</span></option>
                    <option value="Канцелярія"><span>Канцелярія</span></option>
                    <option value="Адміністратор"><span>Адміністратор</span></option>
                </select>
                <div class="auth-form__btns-row">
                    <button type="submit" id="s_auth" class="btns-row__submit"><span>вхід</span></button>
                    <button type="reset" id="r_auth" class="btns-row__reset"><span>відміна</span></button>
                </div>
            </form>
            <div class="content__auth-row">
                <a href="/reg" class="auth-row__link"><span>Зареєструватись</span></a>
            </div>
            <div class="content__auth-rezult" id="a_rezult"></div>
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
