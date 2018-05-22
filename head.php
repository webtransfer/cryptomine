<!doctype html>
<html lang="en">
<head>
	<!-- Define Charset -->
	<meta charset="UTF-8">

	<!-- Page Title -->
	<title>CRYPTO-MINING24.COM - Быстрый способ майнинга криптовалюты.</title>

   <!-- Page Description and Author -->
   <meta name="description" content="content description">
   <meta name="author" content="Coralix Themes">

	<!-- Responsive Metatag -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon  -->
	<link rel="shortcut icon" href="favicon.ico">

    <!-- Stylesheet
    ===================================================================================================  -->
	<link rel="stylesheet" href="/demo2/css/bootstrap.min.css">
	<link rel="stylesheet" href="/demo2/css/style.css">
	<link rel="stylesheet" href="/demo2/css/media-queries.css">

</head>

<body>

    <!--header-->
    <header class="navbar navbar-default navbar-fixed-top">
        <nav class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    
                    <figure class="content-logo">
                        <a class="navbar-brand" href="/"><img src="/demo2/img/logo.png" alt="//"></a>
                    </figure>
                </div>
		
<?
if(isset($_SESSION['id'])){
?>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">
<li><a class="nav-button" data-src="slider" href="/?a=account">Аккаунт</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=deposit">Депозит</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=withdraw">Вывод</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=exchange">Обмен на мощности CM24</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=ref">Партнерка</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=faucet">Бонус</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=exit">Выход</a></li>
</ul>
</div>


<? } else { ?>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav navbar-right">

<li><a class="nav-button" data-src="slider" href="/">Главная</a></li>
<li><a class="nav-button" data-src="features"  href="/?a=faq">FAQ</a></li>
<li><a class="nav-button" data-src="classes" href="/?a=auth">Авторизация</a></li>
<li><a class="nav-button" data-src="teachers" href="/?a=signup">Регистрация</a></li>
<li><a class="nav-button" data-toggle="modal" data-target="#contactmodal" href="/?a=support">Контакты</a></li>
<li><a class="nav-button" data-src="slider" href="/?a=rules">Наша реклама</a></li>
</ul>
</div>
<? } ?>
</ul>
</nav>
</div>
</div>
</div>

</header>

<script type="text/javascript">var CHelp;(function(){var d=document,s=d.createElement("script"),c=d.getElementsByTagName("script"),a=c[c.length-1],h=d.location.protocol;s.src="https://cdn.chathelp.ru/js.min/ch-base.js";s.type="text/javascript";s.async=1;a.parentNode.insertBefore(s,a); s.onload = function(){var siteId = "56e94246551e97da784bf982";CHelp = new ChatHelpJS(siteId);}})()</script>
<body>

  <?php if(!isset($_SESSION['id'])) { ?>   <!-- slider -->
    <section class="slider jumbotron text-center" id="slider">
        <figure></figure>
        <div class="container">
        
            <!-- title -->
            <div class="row title">
                <h2 class="special_font">Crypto-Mining24 - Облачный майнинг</h2>
                <p>
                    Быстрый и самый простой способ майнинга криптовалюты.  
                    <br />
                    Мы - облачный майнинг криптовалюты.   Для начала майнинга больше не нужно дорогостоящее оборудование! 
                </p>
            </div>
            <!-- end title -->
        
            <div class="row">
                <div class="col-lg-8">   
                    
                    <div data-ride="carousel" class="carousel slide" id="carousel-example-generic">
                        <ol class="carousel-indicators">
                            <li class="" data-slide-to="0" data-target="#carousel-example-generic"></li>
                            <li data-slide-to="1" data-target="#carousel-example-generic" class=""></li>
                            <li data-slide-to="2" data-target="#carousel-example-generic" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item">
                                <div class="vendor">
                                    <img alt="" src="images/Bitcoin_Blue.jpg">
                                </div>
                            </div>
                            <div class="item">
                                <div class="vendor">
                                    <img alt="" src="images/6a517d00.jpg">
                                </div>
                            </div>
                            <div class="item active">
                                <div class="vendor">
                                    <img alt="" src="images/cloud-mining-services.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end carousel -->

                </div>
				  
                <div class="col-lg-4">
                    <div class="suscribe animated fadeInRight">
                        <h3>Форма для входа в аккаунт</h3> 
                        
                        <form class="form-signin" action="/?a=auth" method="post">
                              <div class="form-group">
                                  <input type="text" class="form-control" name="email" placeholder="Email" required autofocus />
                              </div>
                              <div class="form-group">
                                  <input type="password" name="pass" class="form-control" placeholder="Password" required />
                              </div>
                              <label class="checkbox">
                                  <input type="checkbox" value="remember-me" />
                                  <font color="#FF7000">Запомнить</font>
                              </label>
                              <button class="btn btn-lg btn-block purple-bg" name="go" type="submit">
                                  Вход</button>
                              </form>
                              <a class="forgotLnk" href="/?a=respass"><font color="#FF7000"><b>Востоновление пароля</b></font></a>
                    </div>
				</div> 
			         
            </div><!-- end row -->         
        </div>
    </section>

  <?php }  ?> 


<?
if(isset($_SESSION['id'])){
?>

<? } ?>