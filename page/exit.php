<?
session_start();
session_destroy();
Header("Location: /");
exit;
?>