<?
Header("Content-Type: text/html;charset=UTF-8");
ob_start();
session_start();
define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'host1378696_mine' );
define( 'DBPASS', 'H48sf38hr53))gt' );
define( 'DBNAME', 'host1378696_mine' );


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

include("func.php");


$invoice_id = intval($_GET['invoice']); //invoice_id is passed back to the callback URL
$transaction_hash = $_GET['transaction_hash'];
$input_transaction_hash = $_GET['input_transaction_hash'];
$input_address = $_GET['input_address'];
$value_in_satoshi = intval($_GET['value']);
$value_in_btc = $value_in_satoshi / 100000000;

if($_GET["destination_address"] != '1KuiV5xhMCe5sQFAphyqvD8fkLCsRPsnRZ') { // Тут проверка на кошелек биткоина
	echo 'Not Valid Address';
	return;
}

if($_GET["secret"] != 'dhgoh49isdfjlkh04dhjk') { //Проверка секретного ключа
	echo 'Not Valid SecretKey';
	return;
}


if($_GET["confirmations"] >= 3) {
	if($value_in_satoshi >= 0.0009)
	{
		$idUser = intval($invoice_id);
		
		$m = $mysql->prepare("UPDATE users SET btc = btc + ?, EnterBtc = EnterBtc + ? WHERE Id = ?");
		$m->execute(array( $value_in_btc, $value_in_btc, $idUser ));
		include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
		$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
		$m->From( "Robot;info@crypto-mine.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
		$m->To( "vitalsonvitalik82@gmail.com" );   // кому, в этом поле так же разрешено указывать имя
		//$m->To( "Robot;vitalsonvitalik82@gmail.com" );   // кому, в этом поле так же разрешено указывать имя
		$m->Subject( "Balance Cripto-Mine" );
		$m->Body("Text Message:<br> <b>Added Balance on ".$value_in_btc." BTC of UserId = ".$idUser."</b>", "html");
		$m->Priority(4) ;	// установка приоритета
		$m->Send();	// отправка
		//$mail = mail('vitalsonvitalik82@gmail.com', "BTC Pay", "Value: ".$value_in_btc);

		echo '*ok*';
	}
	else
	{
		echo '*ok*';
		//return;
	}
}else {
	echo 'Not confirmations';
	return;
}


?>