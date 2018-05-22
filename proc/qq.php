<?
$c = $mysql->query("SELECT * FROM db_cfg WHERE Uid = '1'");
$cfg = $c->fetch();


$price = $cfg['ghs']; //Стоимость GHS
$okup = 60 * 60 * 24 * 300; //Срок окупаемости 12 мес.
$time = time();
$y = $mysql->prepare("SELECT * FROM users WHERE ghs > ?");
$y->execute(array(0));
while($row = $y->fetch())
{
	$countghs = $row['ghs']; // Кол-во GHS
	$speed = ($price / ($okup * $cfg[$row['Mine']])) * $countghs ;
	$speed = sprintf("%01.15f", $speed);
	$countCripto = (sprintf("%01.15f", ($speed + ($speed * 0.0))  * (time() - $row['LastDate'])));
//if($countCripto > 0.000000000000000) 
	//echo $countCripto;
	$cr = $row['Mine'];
	$lstd = time();
	//if(sprintf("%01.15f", $countCripto) > $row[$row['Mine']])
	//{
		$h = $mysql->query("UPDATE users SET `$cr` = `$cr` + '$countCripto', LastDate = '".time()."' WHERE Id = '".$row['Id']."'");
	//}

}
?>