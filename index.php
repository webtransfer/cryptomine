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

include("func.php");


if(isset($_GET['ref']))
{
	$ref = (int)$_GET['ref'];
	$q = $mysql->prepare("SELECT * FROM users WHERE Uid = ?");
	$q->execute(array($ref));
	if($q->rowCount() == 0)
	{
		$refid = 0;
	}
	else
	{
		$refid = $ref;
	}
	
	setcookie("ref", $refid, time()+2592000, '/');
	
}
$t = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$t->execute(array($_SESSION['id']));
$r = $t->fetch();
include("head.php");
include($_SERVER['DOCUMENT_ROOT']."/proc/qq.php");
$ghs = 1.00; //Стоимость гхс в баксах




$g = 0.0000001; //18315
//Парсинг курсов!
$dd = $mysql->prepare("SELECT * FROM db_cfg WHERE Uid = ?");
$dd->execute(array(1));
$ddd = $dd->fetch();
$ghs = $ddd['ghs']; //Стоимость гхс в баксах
if($ddd['DateUpdateCurs'] <= time())
{
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/btc-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceBTC = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/ltc-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceLTC = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/doge-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceDOGE = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/eth-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceETH = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/xmr-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceXMR = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/ppc-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$pricePPC = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/nmc-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceNMC = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/dash-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceDASH = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/blk-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceBLK = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/clam-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceCLAM = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/rdd-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceRDD = $tt['ticker']['price'];
	
	$t = file_get_contents('https://www.cryptonator.com/api/ticker/ftc-usd'); //Тут парсим курс в рублях
	$tt = json_decode($t, true);
	$priceFTC = $tt['ticker']['price'];
	
	
	
	
	$qq = $mysql->prepare("UPDATE db_cfg SET btc = ?, ltc = ?, doge = ?, xrp = ?, eth = ?, ppc= ?, nmc = ?, dash = ?, blk = ?, clam = ?, rdd = ?,  ftc = ?, DateUpdateCurs = ? WHERE Uid = ?");
	$qq->execute(array($priceBTC, $priceLTC, $priceDOGE, $priceXRP, $priceETH, $pricePPC, $priceNMC, $priceDASH, $priceBLK, $priceCLAM, $priceRDD, $priceFTC,
	time() + 360, 1));
}

?>
<script type="text/javascript"src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<?





if(isset($_GET['a']))
{
	$a = clean($_GET['a']);
	switch($a)
	{
		case 'signup': include("page/signup.php"); break;
		case 'index': include("page/index.php"); break;
		case 'auth': include("page/auth.php"); break;
		case 'account': include("page/account.php"); break;
		case 'exchange': include("page/exchange.php"); break;
		case 'deposit': include("page/deposit.php"); break;
		case 'withdraw': include("page/withdraw.php"); break;
		case 'affilate': include("page/affilate.php"); break;
		case 'faucet': include("page/faucet.php"); break;
		case 'profile': include("page/profile.php"); break;
		case 'exit': include("page/exit.php"); break;
		case 'ref': include("page/ref.php"); break;
		case 'rules': include("page/rules.php"); break;
		case 'faq': include("page/faq.php"); break;
		case 'support': include("page/support.php"); break;
		case 'respass': include("page/respass.php"); break;
		case 'bitcoin': include("page/bitcoin.php"); break;
		case 'bonus-reklama': include("page/bonus-reklama.php"); break;
		case 'status': include("page/status.php"); break;
		default: include('page/404.php'); break;
		
		
		
		
		
		
		
	}
}
else
{
	include('page/index.php');
}


include("foot.php");

?>