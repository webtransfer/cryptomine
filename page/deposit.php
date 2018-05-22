<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}
//include($_SERVER['DOCUMENT_ROOT']."/lib/api.php");
//https://api.blockchain.info/v2/receive?xpub=xpub6CWiJoiwxPQni3DFbrQNHWq8kwrL2J1HuBN7zm4xKPCZRmEshc7Dojz4zMah7E4o2GEEbD6HgfG7sQid186Fw9x9akMNKw2mu1PjqacTJB2&callback=https%3A%2F%2Fmystore.com%3Finvoice_id%3D058921123&key=0143a5a9-acd5-4b72-aeb3-8395f89f7e29
//$secret = 'dhgoh49isdfjlkh04dhjk'; //Рандомный секретный ключ
//$my_address = '13N29P9LzTQB7tspr7SWAJeNnxqMWVaYjc'; //Ваш биткоин кошелек куда будут приходить платежи
//$my_xpub = 'xpub6CH43btDNPVzxRT7C3eEWyr6PDQDvLaAvHUn2obaSr1zAxqoVz79pCkvMebau9VHhpEFQ8xrAr14ebDz5qm9z613HvytQzjFeVF9ynuUYtF';
//$my_api_key = '0143a5a9-acd5-4b72-aeb3-8395f89f7e29';
//$id = $_SESSION['id'];
//$my_callback_url = 'http://'.$_SERVER['HTTP_HOST'].'/btc.result.php?invoice_id='.$id.'&secret='.$secret;

//$root_url = 'https://api.blockchain.info/v2/receive';

//$parameters = 'xpub=' .$my_xpub. '&callback='. urlencode($my_callback_url). '&key=' .$my_api_key;
//echo $root_url.$parameters;
//$response = file_get_contents($root_url . '?' . $parameters);
//$object = json_decode($response);
//$btc = $object->address;
?>

<div class="content_fullwidth less1">
<div class="container">
<center>
<h3>
<b>Умнож депозит в 3-раза.</b><br>
Пополни баланс сейчас от 0.05 BTC вы получаете 0.15 BTC</h3>
<h4><b>А ТАКЖЕ <br>
Умнож депозит в 5-раза.</b><br>
 Пополни баланс сейчас от 0.15 BTC вы получаете 0.70 BTC</h4>
</center>
<hr>


<?
if(isset($_POST['amount']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amount']));
	if($sum > 0)
	{
		$q = $mysql->prepare("INSERT INTO db_perfect SET UserId = ?, Summa = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, time(), 0));
		$lid = $mysql->lastInsertId();
		echo '<form action="https://perfectmoney.is/api/step1.asp" method="POST" id="payForm">
					<input type="hidden" name="PAYEE_ACCOUNT" value="U4020320">
					<input type="hidden" name="PAYEE_NAME" value="'.$_SERVER['HTTP_HOST'].'">
					<input type="hidden" name="PAYMENT_ID" value="'.$lid.'">
					<input type="hidden" name="PAYMENT_AMOUNT" value="'.$sum.'">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="http://'.$_SERVER['HTTP_HOST'].'/pmresult.php">
					<input type="hidden" name="PAYMENT_URL" value="http://'.$_SERVER['HTTP_HOST'].'/account/">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="http://'.$_SERVER['HTTP_HOST'].'/account/">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="BAGGAGE_FIELDS" value="">
					<input type="hidden" name="SUGGESTED_MEMO" value="'.$_SERVER['HTTP_HOST'].'">
					</form><script type="text/javascript"> $("#payForm").submit(); </script><span class="green">Please wait...</span>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}

//print_r($_POST);
if(isset($_POST['amountpayeer']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amountpayeer']));
	if($sum > 0)
	{
		$q = $mysql->prepare("INSERT INTO db_perfect SET UserId = ?, Summa = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, time(), 0));
		$lid = $mysql->lastInsertId();
		
		//$lid = $mysql->lastInsertId();
		$desc = base64_encode($_SERVER["HTTP_HOST"]." - ADD BALANCE USER ");
		
		$SecretKey = 'yGACwvuHROaJvmj7'; //Секретный ключ магазина
		$r = array(
			'm_shop' => '125677986', //ID магазина
			'm_orderid' => $lid,
			'm_amount' => number_format($sum, 2, ".", ""),
			'm_curr' => "USD",
			'm_desc' => $desc
		);

		$r['m_sign'] = strtoupper(hash('sha256', implode(':', $r + array($SecretKey))));
		
echo '<form method="POST" action="https://payeer.com/api/merchant/m.php" id="payForm1">
<input type="hidden" name="m_shop" value="'.$r['m_shop'].'">
<input type="hidden" name="m_orderid" value="'.$r['m_orderid'].'">
<input type="hidden" name="m_amount" value="'.$r['m_amount'].'">
<input type="hidden" name="m_curr" value="USD">
<input type="hidden" name="m_desc" value="'.$r['m_desc'].'">
<input type="hidden" name="m_sign" value="'.$r['m_sign'].'">
</form><script type="text/javascript"> $("#payForm1").submit(); </script><span class="green">Please wait...</span>';
		
	}
	else
	{
		echo '<font color="red">Invalid Amount</font>';
	}
}

if(isset($_POST['amountbtc']))
{
	$sum = sprintf ("%01.4f", str_replace(',', '.', $_POST['amountbtc']));
	if($sum >= 0.002)
	{
		$q = $mysql->prepare("INSERT INTO db_paycrypto SET UserId = ?, Summa = ?, `Cur` = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, 'btc', time(), 0));
		$lid = $mysql->lastInsertId();
		
		echo '
<form method="post" action="https://c-cex.com/m.html?m=DF937E792445CBDD46A2FED107EF5F42" id="payFormd">
<input type="hidden" name="coin" value="btc">
<input type="hidden" name="amount" value="'.$sum.'">
<input type="hidden" name="purchase_name" value="Deposit user #'.$r['Uid'].'">
<input type="hidden" name="purchase_id" value="'.$lid.'">
<script type="text/javascript"> $("#payFormd").submit(); </script><span class="green">Please wait...</span>
</form>
</form>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}



if(isset($_POST['amountdash']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amountdash']));
	if($sum >= 1)
	{
		$q = $mysql->prepare("INSERT INTO db_paycrypto SET UserId = ?, Summa = ?, `Cur` = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, 'dash', time(), 0));
		$lid = $mysql->lastInsertId();
		
		echo '
<form method="post" action="https://c-cex.com/m.html?m=DF937E792445CBDD46A2FED107EF5F42" id="payFormd">
<input type="hidden" name="coin" value="dash">
<input type="hidden" name="amount" value="'.$sum.'">
<input type="hidden" name="purchase_name" value="Deposit user #'.$r['Uid'].'">
<input type="hidden" name="purchase_id" value="'.$lid.'">
<script type="text/javascript"> $("#payFormd").submit(); </script><span class="green">Please wait...</span>
</form>
</form>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}


if(isset($_POST['amountdoge']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amountdoge']));
	if($sum >= 50)
	{
		$q = $mysql->prepare("INSERT INTO db_paycrypto SET UserId = ?, Summa = ?, `Cur` = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, 'doge', time(), 0));
		$lid = $mysql->lastInsertId();
		
		echo '
<form method="post" action="https://c-cex.com/m.html?m=DF937E792445CBDD46A2FED107EF5F42" id="payFormd">
<input type="hidden" name="coin" value="doge">
<input type="hidden" name="amount" value="'.$sum.'">
<input type="hidden" name="purchase_name" value="Deposit user #'.$r['Uid'].'">
<input type="hidden" name="purchase_id" value="'.$lid.'">
<script type="text/javascript"> $("#payFormd").submit(); </script><span class="green">Please wait...</span>
</form>
</form>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}

if(isset($_POST['amountltc']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amountltc']));
	if($sum >= 0.5)
	{
		$q = $mysql->prepare("INSERT INTO db_paycrypto SET UserId = ?, Summa = ?, `Cur` = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, 'ltc', time(), 0));
		$lid = $mysql->lastInsertId();
		
		echo '
<form method="post" action="https://c-cex.com/m.html?m=DF937E792445CBDD46A2FED107EF5F42" id="payFormd">
<input type="hidden" name="coin" value="ltc">
<input type="hidden" name="amount" value="'.$sum.'">
<input type="hidden" name="purchase_name" value="Deposit user #'.$r['Uid'].'">
<input type="hidden" name="purchase_id" value="'.$lid.'">
<script type="text/javascript"> $("#payFormd").submit(); </script><span class="green">Please wait...</span>
</form>
</form>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}


if(isset($_POST['amounteth']))
{
	$sum = sprintf ("%01.2f", str_replace(',', '.', $_POST['amounteth']));
	if($sum >= 1)
	{
		$q = $mysql->prepare("INSERT INTO db_paycrypto SET UserId = ?, Summa = ?, `Cur` = ?, DateAdd = ?, Status = ?");
		$q->execute(array($_SESSION['id'], $sum, 'eth', time(), 0));
		$lid = $mysql->lastInsertId();
		
		echo '
<form method="post" action="https://c-cex.com/m.html?m=DF937E792445CBDD46A2FED107EF5F42" id="payFormd">
<input type="hidden" name="coin" value="eth">
<input type="hidden" name="amount" value="'.$sum.'">
<input type="hidden" name="purchase_name" value="Deposit user #'.$r['Uid'].'">
<input type="hidden" name="purchase_id" value="'.$lid.'">
<script type="text/javascript"> $("#payFormd").submit(); </script><span class="green">Please wait...</span>
</form>
</form>';
	}
	else
	{
		echo 'Invalid Amount';
	}
}
?>
<style>
.block {
background: #f5db91;
border-radius: 0.2em;
font-size: 1.125rem;
position: relative;
width: 590px;
height: 290px;
margin: 1em 0px 1em 41px;
border: 1px solid #a57b31;
}
.block_name2 {
font-size: 1.125rem;
position: relative;
margin: 20px 0px 0px 220px;
padding: 5px 15px;
width: 340px;
border-bottom: 1px solid #a57b31;
}
.block_name3 {
font-size: 1.125rem;
position: relative;
margin: 8px 0px 0px 30px;
padding: 5px 15px;
width: 340px;
border-bottom: 1px solid #a57b31;
}
.block_list {
border-radius: 0.3em;
position: relative;
float: right;
margin-right: 30px;
padding: 0px 0px 0px 0px;
width: 331px;
}
.block_img {
font-size: 1.125rem;
margin: 3px;
margin-left: 15px;
text-align: center;
padding: 1px;
width: 192px;
margin-top: -60px;
position: relative;
bottom: -3px;
left: 0px;
}
.block_ul {
padding: 0px;
}
.block_ul li {
color: #2D3E3f;
font-size: 16px;
width: 100%;
position: relative;
padding: 7px 0px;
border-bottom: 2px solid #a57b31;
list-style: outside none none;
}
.block_ul li:last-child {
border-bottom: 0px solid #a57b31;
}
.calc_pz {
width: 18px;
padding: 2px 2px 2px 2px;
margin: 0px 0px 0px 0px;
color: rgb(0, 0, 0);
cursor: pointer;
text-align: center;
font-weight: bold;
background: rgb(69, 198, 72);
border: 1px solid rgb(60, 44, 28);
border-radius: 4px;
}
.calc_mz {
width: 18px;
padding: 2px 2px 2px 2px;
margin: 0px 0px 0px 0px;
color: rgb(0, 0, 0);
cursor: pointer;
text-align: center;
font-weight: bold;
background: rgb(69, 198, 72);
border: 1px solid rgb(60, 44, 28);
border-radius: 4px;
}
.colz {
width: 69px;
padding: 5px 2px 5px 2px;
margin: 0px 0px 0px 0px;
border: 2px solid rgb(60, 44, 28);
background: rgb(255, 255, 255);
color: rgb(165, 123, 49);
cursor: pointer;
text-align: center;
font-weight: bold;
}
#error {
border-color: #EE2327;
}
#good {
border-color: #23EE5B;
}
.alert {
color: #191A18;
margin: 5px 0;
padding: 8px 60px 8px 14px;
text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.5);
background-color: #FCF8E3;
border: 2px solid #3Aa73D;
border-radius: 2px;
}
</style>
<style>
.tabss{
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
background: #f5db91;
border: 1px solid #a57b31;
padding: 10px;
}
</style>	


<center>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Платформа облачного майнинга</title>
    <meta name="viewport" content="width=1300"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="Надежный и быстрый способ начать заработок с минимальными инвестициями" name="description" />
    <meta content="Майнинг, заработок на криптовалюте, биткоины, Mining, Cryptocurrency earning, invest money, invest cryptocurrency, cloud mining" name="keywords" />
	<meta property="og:title" content="Платформа облачного майнинга"/>
	<meta property="og:description" content="Майнинг, заработок на криптовалюте, биткоины, Mining, Cryptocurrency earning, invest money, invest cryptocurrency, cloud mining"/>
<script type="text/javascript" src="/js/jquery.zclip.js"></script>
<script>
$(document).ready(function() {
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function() {
		
		if ( $(this).data('showbutton') == 1 ) {
			$('#buttonBlock').show();
		} else {
			$('#buttonBlock').hide();
		}
		
		//$('.zclip').remove();
		if ( $($(this).attr('href')).find('.zclip').length === 0 ) {
			$('.copy:visible').zclip({
				path: "/js/ZeroClipboard.swf",
				copy: function() {
					//alert($(this).data('wallet'));
					return $(this).data('wallet');
				},
				afterCopy: function(){
					noty({
						text: 'Адрес скопирован!',
						layout: 'bottomRight',
						theme: 'relax',
						type: 'success',
						timeout: false,
						closeWith: ['click', 'button']
					});
				}
			});
		}
	});
});
</script>
<script type="text/javascript">
crypt_multi_num_cur = "5";
crypt_base_cur_0 = "Bitcoin (BTC)";crypt_target_cur_0 = "US Dollar (USD)";crypt_base_cur_1 = "Litecoin (LTC)";crypt_target_cur_1 = "US Dollar (USD)";crypt_base_cur_2 = "Dogecoin (DOGE)";crypt_target_cur_2 = "US Dollar (USD)";crypt_base_cur_3 = "Blackcoin (BLK)";crypt_target_cur_3 = "US Dollar (USD)";crypt_base_cur_4 = "Dash (DASH)";crypt_target_cur_4 = "US Dollar (USD)";crypt_multi_border_corners = "square";crypt_multi_font_family = "Tahoma";</script>


<center>
<h1>Пополнение счета.<br>
Выберите любой способ для пополнения баланса.
</h1>
<div class="panel">
<ul class="nav nav-tabs nav-tabs-simple nav-tabs-right">
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2BTC"><img src="/ing/bitcoin-rotate1.gif" width="60"> BitCoin</a>
</li>
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2Dash"><img src="/ing/DashCoin.png" width="60"> DashCoin</a>
</li>
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2Doge"><img src="/ing/Dogecoin.png" width="60"> DogeCoin</a>
</li>
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2LTC"><img src="/ing/Litecoin.png" width="60"> LiteCoin</a>
</li>
<!--li>
<a data-toggle="tab" data-showbutton="1" href="#tab2ETM"><img src="/ing/Ethereum.png" width="60"> Ethereum</a>
</li-->
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2PM"><img src="/images/perfectmoney.png" width="100"> </a>
</li>
<!--li>
<a data-toggle="tab" data-showbutton="1" href="#tab2Payeer"><img src="/ing/payeer.png" width="60"> Payeer</a>
</li>
<!--li>
<a data-toggle="tab" data-showbutton="1" href="#tab2WM"><img src="/ing/webmoney.png" width="60"> WMZ</a>
</li-->
<li>
<a data-toggle="tab" data-showbutton="1" href="#tab2YA"><img src="/ing/yandex.png" width="65"> </a>
</li>
</ul>


<center>								
<div class="tab-content">
<div class="tab-pane active" id="tab2Rules">
<div class="row column-seperation">
<div class="col-md-12">
<p><h4>После внесения депозита криптовалюты дождитесь зачислен после 3-х подтверждений!
-Комиссии на депозит нет!</h4>
Пополнение счета проходит несколько этапов проверки.<br>Если средства не были зачислены в течении 24 часов - свяжитесь со службой поддержки.<br><br>Внесение депозита предназначено для его последующего обмена на CM24 мощность.</p>
</div>
</div>
</div>





<div class="tab-pane" id="tab2BTC">
<div class="row column-seperation">
<div class="col-md-12"><p>
<h3>Кошелек BitCoin на который нужно отправлять деньги</h3>
<img src="/ing/paymany_menuis/bitcoin-rotate1.gif" width="70" style="float: left;margin-right: 30px;">
<h5><span style="color:#EE0C0C;">Минимальный депозит: 0.002 BTC</span></h5>
Если депозит ниже этой суммы - он может не отображаться в системе.</p>
<!--b>14uybJqZx7wVzeDEjC9Q4Ge5k8YpAKHAfH</b-->
	
<form method="post" action="">
Баланс: <b><input type="text" name="amountbtc" value="0.002" /></b>
<br><br>
<input type="submit" value="Пополнить" />
</form>											
</p>
</div>
</div>
</div>




<div class="tab-pane" id="tab2Dash">
<div class="row column-seperation">
<div class="col-md-12"><p>
<h3>Кошелек DashCoin на который нужно отправлять деньги</h3>
<img src="/ing/DashCoin.png" width="70" style="float: left;margin-right: 30px;">
<h5><span style="color:#EE0C0C;">Минимальный депозит: 1 DashCoin</span></h5>
Если депозит ниже этой суммы - он может не отображаться в системе.</p>
<form method="post" action="">
Баланс: <b><input type="text" name="amountdash" value="1" /></b>
<br><br>
<input type="submit" value="Пополнить" />
</form>
</p>
</div>
</div>
</div>




<div class="tab-pane" id="tab2Doge">
<div class="row column-seperation">
<div class="col-md-12"><p>
<h3>Кошелек DogeCoin на который нужно отправлять деньги</h3>
<img src="/ing/Dogecoin.png" width="70" style="float: left;margin-right: 30px;">											
<h5><span style="color:#EE0C0C;">Минимальный депозит: 50 DogeCoin</span></h5>
Если депозит ниже этой суммы - он может не отображаться в системе.</p>
<form method="post" action="">
Баланс: <b><input type="text" name="amountdoge" value="50" /></b>
<br><br>
<input type="submit" value="Пополнить" />
</form>
</p>
</div>
</div>
</div>




<div class="tab-pane" id="tab2LTC">
<div class="row column-seperation">
<div class="col-md-12"><p>
<h3>Кошелек LiteCoin на который нужно отправлять деньги</h3>
<img src="/ing/Litecoin.png" width="70" style="float: left;margin-right: 30px;">
<h5><span style="color:#EE0C0C;">Минимальный депозит: 0.5 LiteCoin</span></h5>
Если депозит ниже этой суммы - он может не отображаться в системе.</p>
<form method="post" action="">
Баланс: <b><input type="text" name="amountltc" value="0.5" /></b>
<br><br>
<input type="submit" value="Пополнить" />
</form>
</p>
</div>
</div>
</div>



<div class="tab-pane" id="tab2ETM">
<div class="row column-seperation">
<div class="col-md-12"><p>
<h3>Кошелек Ethereum на который нужно отправлять деньги</h3>
<img src="/ing/Ethereum.png" width="70" style="float: left;margin-right: 30px;">
<h5><span style="color:#EE0C0C;">Минимальный депозит: 1 Ethereum</span></h5>
Если депозит ниже этой суммы - он может не отображаться в системе.</p>
<form method="post" action="">
Баланс: <b><input type="text" name="amounteth" value="1" /></b>
<br><br>
<input type="submit" value="Пополнить" />
</form>
</p>
</div>
</div>
</div>


<div class="tab-pane" id="tab2PM">
<div class="row column-seperation">
<div class="col-md-12"><p>
<table border="0" class="tabss" cellspacing="0" cellpadding="0" align="center"><tr>
<td valign="top" width="400px">
<center><img src="/images/perfectmoney.png"></center>
<div class="block_list" style="margin-top: 0px;">
<ul class="block_ul">
<li>Депозит будет зачислен моментально после оплаты<br>
Минимум: 1 USD<br>
Если депозит будет менее минимальной суммы, то он будет не зачислен! </li>		
</ul>
<center><form method="POST" action="">
Сумма в USD:<br>
<input type="text" name="amount" placeholder="1">
<br><br>
<input type="submit" value="Пополнить">
<br></form></center></div></td></tr>
</table>
</p>
</div>
</div>
</div>



<!--div class="tab-pane" id="tab2Payeer">
<div class="row column-seperation">
<div class="col-md-12"><p>
<table border="0" class="tabss" cellspacing="0" cellpadding="0" align="center"><tr>
<td valign="top" width="400px">
<center><img src="/ing/payeer.png"></center>
<div class="block_list" style="margin-top: 0px;">
<ul class="block_ul">
<li>Депозит будет зачислен моментально после оплаты<br>
Минимум: 1 USD<br>
Если депозит будет менее минимальной суммы, то он будет не зачислен! </li></ul>
<center><form method="POST" action="">
Сумма в USD:<br>
<input type="text" name="amountpayeer" placeholder="1.00">
<br><br>
<input type="submit" value="Пополнить">
<br><br>
</form></center></div></td></tr>
</table>
</p>
</div>
</div>
</div>



<div class="tab-pane" id="tab2WM">
<div class="row column-seperation">
<div class="col-md-12"><p>
<table border="0" class="tabss" cellspacing="0" cellpadding="0" align="center"><tr>
<td valign="top" width="400px">
<center><img src="/ing/webmoney.png"></center>
<div class="block_list" style="margin-top: 0px;">
<ul class="block_ul">
<li>Депозит будет зачислен моментально после оплаты<br>
Минимум: 5 USD<br>
В коментариях прописать свой ID и Email: </li></ul>
<center><form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
 <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="5.00">
 <input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="Q1JZUFRPLU1JTklORzI0ICAg0L/QvtC/0L7Qu9C90LXQvdC40LUg0LHQsNC70LDQvdGB0LA=">
 <input type="hidden" name="LMI_PAYEE_PURSE" value="Z426697245113">
<input type="submit" class="wmbtn" style="font-famaly:Verdana, Helvetica, sans-serif!important;padding:0 10px;height:30px;font-size:12px!important;border:1px solid #538ec1!important;background:#a4cef4!important;color:#fff!important;" value=" &#1086;&#1087;&#1083;&#1072;&#1090;&#1080;&#1090;&#1100; 5.00 WMZ ">
</form><br><br></center></div></td></tr>
</table>
</p>
</div>
</div>
</div-->




<div class="tab-pane" id="tab2YA">
<div class="row column-seperation">
<div class="col-md-12"><p>
<table border="0" class="tabss" cellspacing="0" cellpadding="0" align="center"><tr>
<td valign="top" width="500px">
<center><img src="/ing/yandex-logo.png"></center>
<center>
Депозит будет зачислен моментально после оплаты<br>
Минимум: 200 РУБ.<br>
В коментариях прописать свой Email: от АККАУНТА </center>
<center><iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?account=410014076761536&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=%D0%9F%D0%BE%D0%BF%D0%BE%D0%BB%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5+%D0%B1%D0%B0%D0%BB%D0%B0%D0%BD%D1%81%D0%B0+Crypto-Mining24&default-sum=200&button-text=01&fio=on&mail=on&phone=on&successURL=http%3A%2F%2Fcrypto-mining24.com%2F" width="450" height="200"></iframe>
</center></td></tr>
</table>
</p>

</div>
</div>

</center>
</div>
</div>
</div>
</center>
</div>
</div>
</div>