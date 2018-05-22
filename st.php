<?
error_log(print_r($_GET, 1), 3, $_SERVER['DOCUMENT_ROOT'].'/status.txt'); 
error_log(print_r($_POST, 1), 3, $_SERVER['DOCUMENT_ROOT'].'/status.txt'); 