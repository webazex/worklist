<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/Core/autoload.php');
  use Core\App as App;
  use Core\Route\Route as Route;
  if(App::Status_visitor()):
      header("location:/dashboard");
  else:
      header("location:/login");
  endif;
?>