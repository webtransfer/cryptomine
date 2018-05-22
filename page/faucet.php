<div class="content_fullwidth less1">
<div class="container">
<br>
<center>
<script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script>
</center>
<br>
<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}

if(isset($_POST['go']))
{
	
	$code = $_POST['code'];
	if(!empty($_POST['g-recaptcha-response']))
	{
		//$sumHash = rand(1057, 4875);
		//$sum = $sumHash / 10000000;
		$sum = 10;
		$dd = time() + (60*60*24);
		$s = $mysql->query("SELECT * FROM bonus WHERE UserId = '".$_SESSION['id']."' ORDER BY Id DESC LIMIT 1");
		//$s->execute(array($_SESSION['id']));
		$f = $s->fetch();
		if($f['Date'] < time()){
			$d = $mysql->prepare("UPDATE users SET doge = doge + ? WHERE Id = ?");
			$d->execute(array($sum, $_SESSION['id']));
			$mysql->query("INSERT INTO bonus SET UserId = '".$_SESSION['id']."', Date = '$dd'");
			
			echo success("<b><center>Вы получили ".$sum." DogeCoin</center><br></b>");
		}
		else
		{
			echo error('<b><center>Вы уже получили сегодня бонус</center><br></b>');
		}
		/*
		if($s->rowCount() > 0)
		{
			$f = $s->fetch();
			if($f['Date'] <= time())
			{
				$d = $mysql->prepare("UPDATE users SET doge = doge + ? WHERE Id = ?");
				$d->execute(array($sum, $_SESSION['id']));
				$mysql->query("INSERT INTO bonus SET UserId = '".$_SESSION['id']."', Date = '$dd'");
				echo success("You received a bonus of ".$sum." doge");
			}
			else
			{
				echo error('You already received the bonus today');
			}
		}
		*/
	}
	else
	{
		echo error('<font color="#E67E22"><center><b>Не правильная CAPTCHA</b></center><br></font>');
	}
}


?>




<center>
<form method="post" action="" class="form-signin" role="form">
<table>
<tr align="center">



<head>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<form method="post" action="recaptcha.php">

<div class="g-recaptcha" data-sitekey="6LcMhBoTAAAAALR1gqsUX7xBjrImSzhNmppUK02x"></div>
</form>
</body>



</tr>

<tr align="center">
<td>
<br>
<input type="submit" class="btn btn-lg btn-primary btn-block" name="go" value="  Получить бонус  "></td>
</tr>
</table>
</form>
</center>
<br>
</div>
</div>