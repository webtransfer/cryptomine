<?
ob_start();
session_start();
header('Content-type: application/json');
Header("Content-Type: text/html;charset=UTF-8");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' ) { exit();}

define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'koli50_koli50' );
define( 'DBPASS', '12021976' );
define( 'DBNAME', 'koli50_subux ' );


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

include("../func.php");

$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();

$c = $mysql->query("SELECT * FROM db_cfg WHERE Uid = '1'");
$cfg = $c->fetch();


if(isset($_POST['cryptid']))
{
	$IdVal = (int)$_POST['cryptid'];
	$Purse = clean($_POST['nomer']);
	$Sum = sprintf("%01.15f",  str_replace(',', '.', $_POST['count']));
	
	if($IdVal >= 3 and $IdVal <= 14)
	{
		if($Sum > 0)
		{
			if(!empty($Purse))
			{
				switch($IdVal)
				{
					case 3: $Bal = $r['btc']; $min = 0.005; $vlc = 'btc'; $name = 'Bitcoin'; break;
					case 4: $Bal = $r['ltc']; $min = 0.5; $vlc = 'ltc'; $name = 'Litecoin'; break;
					case 5: $Bal = $r['doge']; $min = 5000; $vlc = 'doge'; $name = 'Dogecoin'; break;
					case 6: $Bal = $r['dash']; $min = 1; $vlc = 'dash'; $name = 'Dashcoin'; break;
					case 7: $Bal = $r['blk']; $min = 30; $vlc = 'blk'; $name = 'Blackcoin'; break;
					case 8: $Bal = $r['xmr']; $min = 1.5; $vlc = 'xmr'; $name = 'Monero'; break;
				    case 9: $Bal = $r['eth']; $min = 1; $vlc = 'eth'; $name = 'Ethereum'; break;
				    case 10: $Bal = $r['nmc']; $min = 5; $vlc = 'nmc'; $name = 'NMC'; break;
				    case 11: $Bal = $r['clam']; $min = 3; $vlc = 'clam'; $name = 'Clam'; break;
				    case 12: $Bal = $r['rdd']; $min = 3; $vlc = 'rdd'; $name = 'ReddCoin'; break;
				    case 13: $Bal = $r['ftc']; $min = 3; $vlc = 'ftc'; $name = 'Feathercoin'; break;
					case 14: $Bal = $r['ppc']; $min = 250; $vlc = 'ppc'; $name = 'PeerCoin'; break;
					default: $Bal = $r['btc']; $min = 0.005; $vlc = 'btc'; $name = 'Bitcoin'; break;
				}
				
				if($Bal >= $Sum)
				{
					if($Sum >= $min)
					{
						$q = $mysql->prepare("UPDATE users SET $vlc = $vlc - ? WHERE Id = ?");
						$q->execute(array($Sum, $_SESSION['id']));
						$w = $mysql->prepare("INSERT INTO db_vivod SET UserId = ?, Purse = ?, Summa = ?, DateAdd = ?, PaySystem = ?, Status = ?");
						$w->execute(array($_SESSION['id'], $Purse, $Sum, time(), $name, 0));
						
						echo "Успешно";
					}
					else
					{
						echo "Wrong Amount1"; exit;
					}
				}
				else
				{
					echo 'Wrong Amount'; exit;
				}
			}
			else
			{
				echo "Wrong cryptocurrency address"; exit;
			}
		}
		else
		{
			echo "Wrong Amount"; exit;
		}
	}
	else
	{
		echo "Wrong Valuta"; exit;
	}
}
if(isset($_POST['cryptidex']))
{
	$IdVal = (int)$_POST['cryptidex'];
	//$Purse = clean($_POST['nomer']);
	$Sum = sprintf("%01.15f",  str_replace(',', '.', $_POST['count']));
	
	if($IdVal >= 3 && $IdVal <= 14)
	{
		if($Sum > 0)
		{
			switch($IdVal)
			{
					case 4: $Bal = $r['ltc']; $min = 0.5; $vlc = 'ltc'; $name = 'Litecoin'; break;
					case 5: $Bal = $r['doge']; $min = 5000; $vlc = 'doge'; $name = 'Dogecoin'; break;
					case 6: $Bal = $r['dash']; $min = 1; $vlc = 'dash'; $name = 'Dashcoin'; break;
					case 7: $Bal = $r['blk']; $min = 30; $vlc = 'blk'; $name = 'Blackcoin'; break;
					case 8: $Bal = $r['xmr']; $min = 1.5; $vlc = 'xmr'; $name = 'Monero'; break;
				    case 9: $Bal = $r['eth']; $min = 1; $vlc = 'eth'; $name = 'Ethereum'; break;
				    case 10: $Bal = $r['nmc']; $min = 5; $vlc = 'nmc'; $name = 'NMC'; break;
				    case 11: $Bal = $r['clam']; $min = 3; $vlc = 'clam'; $name = 'Clam'; break;
				    case 12: $Bal = $r['rdd']; $min = 3; $vlc = 'rdd'; $name = 'ReddCoin'; break;
				    case 13: $Bal = $r['ftc']; $min = 3; $vlc = 'ftc'; $name = 'Feathercoin'; break;
					case 14: $Bal = $r['ppc']; $min = 250; $vlc = 'ppc'; $name = 'PeerCoin'; break;
					default: $Bal = $r['btc']; $min = 0.005; $vlc = 'btc'; $name = 'Bitcoin'; break;
			}
			
			if($Sum <= $Bal)
			{
				$GhsNew = sprintf("%01.15f", $cfg[$vlc] * $Sum * $cfg['ghs']);
				$refGhs = $GhsNew * 0.001;
				$q = $mysql->prepare("UPDATE users SET ghs = ghs + ?, $vlc = $vlc - ? WHERE Id = ?");
				$q->execute(array($GhsNew, $Sum, $_SESSION['id']));
				$w = $mysql->prepare("UPDATE users SET ghs = ghs + ?, RefM = RefM + ? WHERE Uid = ?");
				$w->execute(array($refGhs, $refGhs, $r['RefId']));
				echo "Успешно";
			}
			else
			{
				echo "Wrong Amount"; exit;
			}
		}
		else
		{
			echo "Wrong Amount"; exit;
		}
	}
	else
	{
		echo "Wrong Crypto Curency"; exit;
	}
}





?>