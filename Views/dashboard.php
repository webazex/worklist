<?php
//session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Core/autoload.php');
use Core\App as app;
$controller = app::getController(__FILE__);
$user = getUserData();
date_default_timezone_set('Europe/Kiev');
if(app::Status_visitor()):
    else:
        header("location:/login");
    endif;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Робоча область</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Sources/main.css">
</head>
<body>
<div class="site-size">
    <header>
        <?php getHiMessage(); getHeaderTitle(); getLogout();?>
    </header>
    <main>
        <button type="button" id="btn_up" class="button-Up"><span>Вгору</span></button>
        <div class="main__panels">
            <div class="no-display">
                <span>
                Мінімально можливе розширення екрану\робочого столу 1200 на 768. Змініть розширення робочого столу, або викоистовуйте більш новий монітор.
                </span>
            </div>
            <?php getTemplate(); ?>
        </div>
    </main>
    <footer>
        <div class="footer-box">
            <span>Beta - версія.</span>
            <span>v. 0.1</span>
        </div>
    </footer>
</div>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="/Sources/main.js"></script>
</body>
</html>
