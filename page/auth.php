<div class="content_fullwidth less2">
<div class="container">
<div class="logregform two">
<?
if(isset($_SESSION['id']))
{
	Header("Location: /?a=account");
	exit;
}
if(isset($_POST['go']))
{
	$email = IsMail($_POST['email']);
	$pass = md5pass($_POST['pass']);
	
	if($email !== FALSE)
	{
			
		
		$r = $mysql->prepare("SELECT * FROM users WHERE Email = ? AND Password = ?");
		$r->execute(array($email, $pass));
		if($r->rowCount() == 1)
		{
			$q = $r->fetch();
			$_SESSION['id'] = $q['Id'];
			echo success('<center><b>Вы успешно авторизовались! Перенаправление в аккаунт</center></b>');
			Header("Location: /?a=account");
			//exit();
		}
		else
		{
			echo error('<center><b>Не правильные данные</center></b>');
		}
	}
	else
	{
		echo error('<center><b>Не тот формат E-Mail</center></b>');
	}
}
?>

<div class="changerWidget-container" data-size="300x35"></div>
</center>
<center><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script></center>
<div class="title">
<h3></b>ВХОД В АККАУНТ</b></h3>
<p><b>Еще не зарегистрированы?</b> &nbsp;<a href="/?a=signup"><b>Зарегистрируйтесь!</b></a></p>
</div>
<div class="feildcont">
<form class="form-signin" method="post" role="form">
<h2 class="form-signin-heading">Авторизация</h2>
<input autofocus="" class="form-control" name="email" placeholder="Email address" required="" type="email"><br>
<input class="form-control" name="pass" placeholder="Password" required="" type="password"> <button class=
"btn btn-lg btn-primary btn-block" name="go" type="submit">АВТОРИЗОВАТЬСЯ</button></form>
<br>
<b>Забыли пароль?</b> <a href="/?a=respass"><b>Востановление пароля</b></a>
<br><br><br><br>


</div>
</div>
</div>
</div>