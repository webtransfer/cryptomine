<?
Header("Content-Type: text/html;charset=UTF-8");
ob_start();
session_start();
define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'CM24' );
define( 'DBPASS', 'L0JFBheG' );
define( 'DBNAME', 'CM24' );


//Подключаемся к базе данных
$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . "";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);


try {
    $mysql = new PDO($dsn, DBUSER, DBPASS);
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}


$mysql->exec("SET NAMES utf8 COLLATE utf8_general_ci");
$mysql->exec("SET CHARACTER SET utf8");

include($_SERVER['DOCUMENT_ROOT']."/func.php");

$q = $mysql->query("SELECT * FROM users");
while($w = $q->fetch())
{
 $e = $mysql->prepare("UPDATE users SET doge = doge + ? WHERE Id = ?");
 $e->execute(array(20, $w['Id']));
}
 ?>