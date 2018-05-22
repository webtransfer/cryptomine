
<?
Header("Content-Type: text/html;charset=UTF-8");
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
?>
<center><a href="/1.php">USERS</a></center>
<br><hr><br>
<table border="1">
<tr>
<td>UID</td>
<td>Email</td>
<td>Пополнено BTC</td>
<td>Пополнено DOGE</td>
<td>Пополнено LTC</td>
<td>Колво реф</td>
<td>GHS</td>
<td>BTC</td>
<td>LTC</td>
<td>DOGE</td>
<td>BLK</td>
<td>DASH</td>
<td>NMC</td>
<td>PPC</td>
<td>XMR</td>
<td>Mine</td>
</tr>

<?
$q = $mysql->query("SELECT * FROM users ORDER BY Uid DESC");
while($w = $q->fetch())
{
	if($w['ghs'] >= 1) { $st = "<font color=red>"; $st1 = '</font>'; }
	else
	{
		$st = ""; $st1 = '';
	}
	
	$t = $mysql->prepare("SELECT * FROM users WHERE RefId = ?");
	$t->execute(array($w['Uid']));
	?>
	<tr>
<td><?=$w['Id'];?></td>
<td><?=$w['Email'];?></td>
<td><?=$w['EnterBtc'];?></td>
<td><?=$w['EnterDoge'];?></td>
<td><?=$w['EnterLtc'];?></td>
<td><?=$t->rowCount();?></td>
<td><?=$st;?><?=$w['ghs'];?><?=$st1;?></td>
<td><?=$w['btc'];?></td>
<td><?=$w['ltc'];?></td>
<td><?=$w['doge'];?></td>
<td><?=$w['blk'];?></td>
<td><?=$w['dash'];?></td>
<td><?=$w['nmc'];?></td>
<td><?=$w['ppc'];?></td>
<td><?=$w['xmr'];?></td>
<td><?=$w['Mine'];?></td>
</tr>
	<?
}
?>
</table>