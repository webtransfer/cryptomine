<?
ob_start();
session_start();
define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'koli50_koli50' );
define( 'DBPASS', '12021976' );
define( 'DBNAME', 'koli50_subux' );


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


$q = $mysql->query("SELECT * FROM users WHERE BtcPurse != ''");
if($q->rowCount() > 0)
{
	$bal = 0;
	include($_SERVER['DOCUMENT_ROOT']."/lib/api.php");
	while($w = $q->fetch())
	{
		
		$t = file_get_contents('https://chain.so/api/v2/get_address_balance/BTC/'.$w['BtcPurse'].'/0'); //Тут парсим курс в рублях
		$tt = json_decode($t, true);
		$balance = $tt['data']['confirmed_balance'];
		if($balance > 0)
		{
			$e = $mysql->prepare("UPDATE users SET btc = btc + ? WHERE Id = ?");
			$e->execute(array($balance, $w['Id']));
			$bal = $bal + $balance;
		}
		echo $balance;
	}
	$result = api_query("sendpayment", array("currency_id" => 22, "target_address" => "1KuiV5xhMCe5sQFAphyqvD8fkLCsRPsnRZ", "send_value" => $bal));
	echo "<pre>".print_r($result, true)."</pre>";
}


?>