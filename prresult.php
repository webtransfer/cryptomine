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

$m_key = 'yGACwvuHROaJvmj7';

if(isset($_POST["m_operation_id"])) {

	$arHash = array(
		$_POST['m_operation_id'],
		$_POST['m_operation_ps'],
		$_POST['m_operation_date'],
		$_POST['m_operation_pay_date'],
		$_POST['m_shop'],
		$_POST['m_orderid'],
		$_POST['m_amount'],
		$_POST['m_curr'],
		$_POST['m_desc'],
		$_POST['m_status'],
		$m_key
	);

$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));


	if($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success" && $_POST['m_curr']=='USD') {
	
		$q = $mysql->prepare("SELECT * FROM db_perfect WHERE Uid = ?");
		$q->execute(array($_POST['m_orderid']));
		
		if($q->rowCount() == 1)
		{
			$w = $q->fetch();
			if($w['Status'] == 0)
			{
				
					$q = $mysql->prepare("UPDATE users SET ghs = ghs + ?, `dep_usd` = `dep_usd` + ? WHERE Id = ?");
					$q->execute(array($w['Summa'], $w['Summa'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_perfect SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $_POST['m_orderid']));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;crypto-mine.com@yandex.ru" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "crypto-mine.com@yandex.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;vitalsonvitalik82@gmail.com" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Cripto-Mine" );
					$m->Body("Текст сообщения:<br> <b>Пополнен баланс на ".$w['Summa']." Payeer of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				
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
exit;
} 