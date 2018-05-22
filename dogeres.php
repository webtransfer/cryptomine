<?
Header("Content-Type: text/html;charset=UTF-8");
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT']."/config.php");

include("func.php");

$invoice_id = intval($_POST['invoice']); //invoice_id is passed back to the callback URL
$transaction_hash = $_POST['transaction_hash'];
$value_in_satoshi = intval($_POST['value']);

if($_POST["destination_address"] != 'DK5Be9giyMHaz6gy1vyyXs1JARdU1Y8Ae4') { // Тут проверка на кошелек биткоина
	echo 'Not Valid Address11';
	die();
}

if($_POST["secret"] != 'dhgoh49isdfjlkh04') { //Проверка секретного ключа
	echo 'Not Valid SecretKey';
	die();
}


if($_POST["confirmations"] >= 3) {
	if($value_in_satoshi >= 50)
	{
		
		$idUser = intval($invoice_id);
		
		$m = $mysql->prepare("UPDATE users SET doge = doge + ?, EnterDoge = EnterDoge + ? WHERE Id = ?");
		$m->execute(array( ($value_in_satoshi - 1), ($value_in_satoshi - 1), $idUser ));
		

		echo '*ok*';
		die();
	}
	else
	{
		die();
	}
}else {
	echo 'Not confirmations';
	die();
}


?>