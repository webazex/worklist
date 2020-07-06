<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Core/autoload.php');
use Core\Classes\User as user;
use Core\Route\Route as Route;
//user::valid_user('1');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//$dir = "/volume1/attaches/";
//$scan = scandir($dir.'/2/');
//print_r($scan);
$list = array(
        'економічний (econom.med.ks@ukr.net)', 'асу (medstat-kherson@ukr.net)',
        'технічний відділ (to-oz@ukr.net)', 'Левко (medstat-centr@ukr.net)',
        'Курдіна (tanya.kurdina@ukr.net)', 'ЕОЗ (e-health@ukr.net)',
    'Канцелярія (kanc-medstat@ukr.net)'
);
//економічний (econom.med.ks@ukr.net), асу (medstat-kherson@ukr.net), технічний відділ (to-oz@ukr.net), Левко (medstat-centr@ukr.net), Курдіна (tanya.kurdina@ukr.net), ЕОЗ (e-health@ukr.net), Канцелярія (kanc-medstat@ukr.net)
echo('<hr>');

echo __FILE__.'<br>';
// Открыть заведомо существующий каталог и начать считывать его содержимое
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            print "Файл: $file : тип: " . filetype($dir . $file) . ".'<br>'";
        }
        closedir($dh);
    }
}

$root = $_SERVER['DOCUMENT_ROOT'];
$path = $_SERVER['REQUEST_URI'];
//print_r($root);
echo('<br>');
//print_r($path);
//$a = App::getView('login');
//echo $a;

        ?>
        <html>
        <head>
        </head>
        <body>
        <form action="" id="f" method="POST">
        <input type="text" name="test">
        <button type="submit" name="rolez" id="b">send</button>
        <div id="rezult"></div>
        </form>
        <button type="button" name="tt" id="t">time</button>
        <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <script>
  $(document).ready(function(){
      
    $('#b').click(function(){
        event.preventDefault();
        console.log($("#f").serialize());
        $.ajax({
        url:     '/Core/Classes/DB.php', //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#f").serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	// result = $.parseJSON(response);
            rezult = response;
        	$('#result_form').html(rezult);
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
    });
      function getCurrentDate() {
          let date = {'date': true}
          $.ajax({
              url:    '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
              type:     "POST", //метод отправки
              dataType: "html", //формат данных
              data: date,  // Сеарилизуем объект
              success: function(response) { //Данные отправлены успешно
                  console.log(response);
              },
              error: function(response) { // Данные не отправлены
                  console.log("don't send");
              }
          });
      }
      $('#t').click(function () {
          getCurrentDate();
      });
  });
  </script>
        </body>
        </html>