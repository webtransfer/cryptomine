<div class="content_fullwidth less2">
    <div class="container">
        <div class="logregform two">
            <?

            function getIp()
            {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ret = $_SERVER['HTTP_CLIENT_IP'];
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ret = $_SERVER['HTTP_X_FORWARDED_FOR'];
                else $ret = $_SERVER['REMOTE_ADDR'];
                $exp = explode(',', $ret);
                return $exp['0'];
            }


            if (isset($_SESSION['id'])) {
                Header("Location: /account");
                exit;
            }
            if (isset($_POST['go'])) {
                $email = IsMail($_POST['email']);
                $pass = md5pass($_POST['pass']);
                $reff = (int)$_COOKIE['ref'];
                $ip = getIp();
                $login = $_POST['login'];
				
                if ($email !== FALSE) {
                    $r = $mysql->prepare("SELECT * FROM users WHERE Email = ?");
                    $r->execute(array($email));
                    if ($r->rowCount() == 0) {
                        $l = $mysql->prepare("SELECT * FROM users WHERE UsLogin = ?");
                        $l->execute(array($login));
                    if ($l->rowCount() == 0) {
                        $i = $mysql->prepare("SELECT * FROM users WHERE ip = ?");
                        $i->execute(array($ip));
                        if ($i->rowCount() == 0) {
                            $q = $mysql->prepare("INSERT INTO users SET Uid = ?, UsLogin = ?, Email = ?, Password = ?, RefId = ?, doge = ?, ip = ?");
                            $q->execute(array(time(), $login, $email, $pass, $reff, 2000, $ip));
							
							$i = $mysql->prepare("SELECT * FROM users WHERE Uid = ?");
							$i->execute(array($reff));
							if($i->rowCount() == 1)
							{
								$q = $mysql->prepare("UPDATE users SET doge = doge + ? WHERE Uid = ?");
								$q->execute(array(10, $reff));
							}
							
                            echo success('<b><center>Вы успешно зарегистрировались! Теперь Вы можете войти в свой аккаунт</center></b><br>');
                        } else echo error('<b><center>С этого компьютера регистрация уже была произведена!</center></b><br>');
                    } else echo error('<b><center>Этот логин уже зарегистрирован</center></b><br>');
                    } else echo error('<b><center>Эта электронная почта уже зарегистрирована</center></b><br>');
                } else echo error('<b><center>Не тот формат E-Mail</center></b>');
            }

?>
            
			<div class="title">
            <h3><b>Регистрация</b></h3>

            <p><b>Уже регистрировались?</b> &nbsp;<a href="/?a=auth"><b>Авторизуйтесь!</b></a></p>
            </div>
            <div class="feildcont">
			
                <form class="form-signin" method="post" role="form">
                    <h2 class="form-signin-heading">
                        <center><b>Пожалуйста зарегистрируйтесь</b></center>
                    </h2>
                    <? if ($_COOKIE['ref']) echo '<b>ID вышестоящего:</b> ' . $_COOKIE['ref']; ?>
                    <br><br>
                    <input class="form-control" name='login' placeholder="Login" required="" type="text"><br>
                    <input autofocus="" class="form-control" name='email' placeholder="Email address" required="" type="email"><br>
                    <input class="form-control" name="pass" placeholder="Password" required="" type="password">
                    <button class=
                            "btn btn-lg btn-primary btn-block" name="go" type="registar.html">Зарегистрироваться.
                    </button>
                </form>
				
				<br>
            </div>
        </div>
    </div>
</div>