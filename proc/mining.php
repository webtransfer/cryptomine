<?
ob_start();
session_start();
define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'cryptomine' );
define( 'DBPASS', 'cryptomine' );
define( 'DBNAME', 'cryptomine' );


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
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();
if(isset($_POST['id']))
{
	include($_SERVER['DOCUMENT_ROOT']."/proc/qq.php");
	$id = abs(intval($_POST['id']));
	switch($id)
	{
		case 1: $val = 'btc'; break;
		case 2: $val = 'ltc'; break;
		case 3: $val = 'doge'; break;
		case 4: $val = 'blk'; break;
		case 5: $val = 'dash'; break;
		case 6: $val = 'nmc'; break;
		case 7: $val = 'ppc'; break;
		case 8: $val = 'xrp'; break;
		case 9: $val = 'eth'; break;
		case 10: $val = 'ghs'; break;
		case 11: $val = 'clam'; break;
		case 12: $val = 'rdd'; break;
		case 13: $val = 'ftc'; break;
		case 14: $val = 'xmr'; break;
		case 15: $val = 'unc'; break;
		default: $val = 'btc'; break;
	}
	
	if($r['ghs'] > 0)
	{
		$q = $mysql->prepare("UPDATE users SET Mine = ?, LastDate = ? WHERE Id = ?");
		$q->execute(array($val, time(), $_SESSION['id']));
		exit;
	}
	
}
else exit;
?>