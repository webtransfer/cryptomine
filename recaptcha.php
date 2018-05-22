<head>
<meta charset="utf-8" />
<title>главная</title>
<script src='https://www.google.com/recaptcha/api.js' async></script>
</head>
<body>
<?php
 if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
    $secret = '6LdTFxUTAAAAAFEu7iq48Prj7SaTrAQ1uCmrGwuW';
    $ip = $_SERVER['REMOTE_ADDR'];
	$response = $_POST['g-recaptcha-response'];
	$rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
	var_dump($rsp);
 }
?>
</body>