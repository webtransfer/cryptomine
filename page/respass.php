
<div class="content_fullwidth less1">
<div class="container">	
<div style="margin: 20px 20px;">
<br><br>
<?
if(isset($_SESSION['id']))
{
	Header("Location: /account");
	exit;
}
if(isset($_POST['go']))
{
	$email = clean($_POST['email']);
	
	
	$r = $mysql->prepare("SELECT * FROM users WHERE Email = ?");
	$r->execute(array($email));
	if($r->rowCount() == 1)
	{
		$q = $r->fetch();
		$NewPass = generate_password(10);
		$ResPass = md5pass($NewPass);
		$w = $mysql->prepare("UPDATE users SET Password = ? WHERE Email = ?");
		$w->execute(array($ResPass, $email));
		include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
		$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
		$m->From( "Robot;info@crypto-mining24.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
		$m->To( $email );   // кому, в этом поле так же разрешено указывать имя
		$m->Subject( "Reset Password" );
		$m->Body("You new password <b>".$NewPass."</b>", "html");
		$m->Priority(4) ;	// установка приоритета
		$m->Send();	// отправка
		echo success('Новый пароль отправлен Вам на E-Mail');
		
		
	}
	else
	{
		echo error('Не правильные данные');
	}
}
?>



<form class="form-signin" role="form" method="POST" action="">
        <h2 class="form-signin-heading">Востановление пароля</h2>
        <input type="email" class="form-control" name='email' placeholder="Email адрес" required autofocus><br>
       <button class="btn btn-lg btn-primary btn-block" name="go" type="submit">Востановление пароля</button>
</form>

<br>
  
<center><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script></center>	  
	  
	  </div>
	  </div>
	  </div>