<?
if(isset($_POST['pass1']))
{
	$pass1 = md5pass($_POST['pass1']);
	$pass2 = md5pass($_POST['pass2']);
	if($pass1 == $pass2)
	{
		$q = $mysql->prepare("UPDATE users SET Password = ? WHERE Id = ?");
		$q->execute(array($pass2, $_SESSION['id']));
		echo success('The password is changed');
		Header("Refresh: 2, /account");
	}
	else
	{
		echo error('пароли не совпадают');
	}
}
?>
<div class="content_fullwidth less1">
<div class="container">	 
 
<div style="margin: 20px 20px;">
<center><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- crypto-mine -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3833441476016070"
     data-ad-slot="7928021146"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<iframe data-aa='109720' src='https://ad.a-ads.com/109720?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true' frameborder='0'></iframe>

</center>
<a href="/profile" class="btn btn-xs btn-primary pull-right" style="margin:10px;"><div class="my-account-name"><small>ID: <?=$r['Uid'];?></small></div><span class="glyphicon glyphicon-picture"></span> ВАШ ПРОФИЛЬ</a>
<form class="form-signin" role="form" method="POST" action="">
        <h2 class="form-signin-heading">Изменение пароля</h2>
        <input type="password" class="form-control" name='pass1' placeholder="Новый пароль" required><br>
        <input type="password" class="form-control" name="pass2" placeholder="Повтор пароля" required>
        <br>
        <button class="btn btn-lg btn-primary btn-block" name="go" type="submit">Сохранить</button>
      </form>
</div>
</div>
</div>
</div>
</div>