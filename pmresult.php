<?
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

$ALTERNATE_PHRASE_HASHH = strtoupper(md5('33i2nGz25MkPVEnaCinrgpVKd'));
$string = $_REQUEST['PAYMENT_ID'].':'.$_REQUEST['PAYEE_ACCOUNT'].':'.$_REQUEST['PAYMENT_AMOUNT'].':'.$_REQUEST['PAYMENT_UNITS'].':'.$_REQUEST['PAYMENT_BATCH_NUM'].':'.$_REQUEST['PAYER_ACCOUNT'].':'.$ALTERNATE_PHRASE_HASHH.':'.$_REQUEST['TIMESTAMPGMT'];

$hash = strtoupper(md5($string));

if($hash==$_REQUEST['V2_HASH']) {
	
	$q = $mysql->prepare("SELECT * FROM db_perfect WHERE Uid = ?");
	$q->execute(array($_REQUEST['PAYMENT_ID']));
	
	if($q->rowCount() == 1)
	{
		$w = $q->fetch();
		if($w['Status'] == 0)
		{
			if(sprintf("%01.2f", $_REQUEST['PAYMENT_AMOUNT'])==$w['Summa'] && $_REQUEST['PAYEE_ACCOUNT']=='U4020320' && $_REQUEST['PAYMENT_UNITS']=='USD')
			{
				$q = $mysql->prepare("UPDATE users SET ghs = ghs + ? WHERE Id = ?");
				$q->execute(array($w['Summa'], $w['UserId']));
				$e = $mysql->prepare("UPDATE db_perfect SET Status = ? WHERE Uid = ?");
				$e->execute(array(1, $_REQUEST['PAYMENT_ID']));
				include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
				$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
				$m->From( "Robot;info@crypto-mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
				$m->To( "vitalsonvitalik82@gmail.com" );   // кому, в этом поле так же разрешено указывать имя
				$m->Subject( "Balance Crypto-Mining24" );
				$m->Body("Text Message:<br> <b>Added Balance on ".$w['Summa']." PerfectMoney of UserId = ".$w['UserId']."</b>", "html");
				$m->Priority(4) ;	// установка приоритета
				$m->Send();	// отправка
				exit;
			}
		}
		else
		{
			exit;
		}
	}
	else
	{
		exit;
	}

	
exit;
} 