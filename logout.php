<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Core/autoload.php');
session_destroy();
header("location:/login");
