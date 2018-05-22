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
error_log(print_r($_GET, 1), 7, $_SERVER['DOCUMENT_ROOT'].'/status.txt'); 
if(isset($_GET['ccexmpurchaseid']))
{
	$id = (int)$_GET['ccexmpurchaseid'];
	$q = $mysql->prepare("SELECT * FROM db_paycrypto WHERE Uid = ?");
	$q->execute(array($id));
	if($q->rowCount() == 1)
	{
		$w = $q->fetch();
		if($w['Summa'] <= $_GET['ccexmamount'])
		{
			if($_GET['ccexmcoin'] == 'doge' and $w['Cur'] == 'doge')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET doge = doge + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." DOGE of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}
			elseif($_GET['ccexmcoin'] == 'ltc' and $w['Cur'] == 'ltc')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET ltc = ltc + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." LTC of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}

			elseif($_GET['ccexmcoin'] == 'btc' and $w['Cur'] == 'btc')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET btc = btc + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." BTC of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}
			
			elseif($_GET['ccexmcoin'] == 'dash' and $w['Cur'] == 'dash')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET dash = dash + ?, EnterDash = EnterDash + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." DASH of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}
						elseif($_GET['ccexmcoin'] == 'amp' and $w['Cur'] == 'amp')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET amp = amp + ?, EnterAmp = EnterAmp + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." AMP of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}
					elseif($_GET['ccexmcoin'] == 'bac' and $w['Cur'] == 'bac')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET bac = bac + ?, EnterBac = EnterBac + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." BAC of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
				
					elseif($_GET['ccexmcoin'] == 'eth' and $w['Cur'] == 'eth')
			{
				if($w['Status'] == 0)
				{
					$q = $mysql->prepare("UPDATE users SET eth = eth + ?, EnterEth = EnterEth + ? WHERE Id = ?");
					$q->execute(array($_GET['ccexmamount'], $_GET['ccexmamount'], $w['UserId']));
					$e = $mysql->prepare("UPDATE db_paycrypto SET Status = ? WHERE Uid = ?");
					$e->execute(array(1, $id));
					include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
					$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
					$m->From( "Robot;info@Crypto-Mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
					$m->To( "e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
					$m->Subject( "Balance Crypto-Mining24" );
					$m->Body("Text Message:<br> <b>Added Balance on ".$_GET['ccexmamount']." ETH of UserId = ".$w['UserId']."</b>", "html");
					$m->Priority(4) ;	// установка приоритета
					$m->Send();	// отправка
					exit;
				}
				else
					exit;
			}
			else
				exit;				
			}
			else
				exit;
		}			
			else
				exit;
		}
		else
			exit;
	}
	else
		exit;
}
else
	exit;
}
else
	exit;