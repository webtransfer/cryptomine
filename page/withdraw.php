<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}
/*
if(isset($_POST['go']))
{
	$purse = clean($_POST['purse']);
	$sum = $_POST['count'];
	
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();

$t = file_get_contents('https://btc-e.com/api/3/ticker/btc_usd'); //Тут парсим курс в рублях
$tt = json_decode($t, true);
$sumBTC = sprintf ("%01.8f", str_replace(',', '.', ($sum * $tt['btc_usd']['sell']))) ; 
if($sum <= $r['Usd'])
{
	$q = $mysql->prepare("INSERT INTO pay SET UserId = ?, Purse = ?, Sum = ?, Status = ?");
	$q->execute(array($_SESSION['id'], $purse, $sum, 0));
	$d = $mysql->prepare("UPDATE users SET Usd = Usd - ? WHERE Uid = ?");
	$d->execute(array($sumBTC, $_SESSION['id']));
}
else
{
	echo error('Insufficient funds');
}

}
*/

$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();
?>
<div class="content_fullwidth less1">
<div class="container">	 

<center>  
<h1>Вывод средств</h1>
<b>Запросы на вывод средств обрабатываются в течение 24 часов.</b><br><br>
<span style="color:#0066a9;" title=""><b>Минимальная сумма вывода: <br><br>
0.005 BTC | 0.5 LTC | 5000 DOGE | 1 DASH <!--| 30 BLK | 250 PPC | 5 NMC--> </b></span>
<div style="margin: 20px 0 0 0; text-align: center;">
</center>

<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}
/*
if(isset($_POST['go']))
{
	$purse = clean($_POST['purse']);
	$sum = $_POST['count'];
	
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();

$t = file_get_contents('https://btc-e.com/api/3/ticker/btc_usd'); //Тут парсим курс в рублях
$tt = json_decode($t, true);
$sumBTC = sprintf ("%01.8f", str_replace(',', '.', ($sum * $tt['btc_usd']['sell']))) ; 
if($sum <= $r['Usd'])
{
	$q = $mysql->prepare("INSERT INTO pay SET UserId = ?, Purse = ?, Sum = ?, Status = ?");
	$q->execute(array($_SESSION['id'], $purse, $sum, 0));
	$d = $mysql->prepare("UPDATE users SET Usd = Usd - ? WHERE Uid = ?");
	$d->execute(array($sumBTC, $_SESSION['id']));
}
else
{
	echo error('Insufficient funds');
}

}
*/

$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();
?>
<div class="content_fullwidth less1">
<div class="container">	 

<hr>

<center>
<form action="/withdraw" name="vivod" method="post" id="vuvod">
<table style="width: 800px">
<tbody><tr>
<td>
<select class="form-control" style="height:40px;" name="cryptid" onchange="cryptcahnge()" id="change">
	<option dat="<?=$r['btc']; ?>" value="3">BitCoin</option>
	<option dat="<?=$r['ltc']; ?>" value="4">LiteCoin</option>
	<option dat="<?=$r['doge']; ?>" value="5">DogeCoin</option>
	<option dat="<?=$r['dash']; ?>" value="6">DashCoin</option>
	<!--option dat="<?=$r['blk']; ?>" value="9">Blackcoin</option>
	<option dat="<?=$r['ppc']; ?>" value="10">PeerCoin</option-->
</select>
<br>
<br>

<center>
<div align="center">
<img id="img" src="/ing/Dogecoin.png" alt="" height="90" style="display: block; ">
</div>
<br>
<input type="text" name="count" style="height: 30px; width: 300px; font-size: 16px; font-family: Verdana" value="<?=$r['btc']; ?>" id="countchange">
</td>
<td style="width: 40px">&nbsp;</td>
<td>
<label style="margin: 15px 0 0 0;">
<font style="color: #727171; font-size: 15px; font-weight: bolder; line-height: 150%;text-shadow: # 0px 1px 1px;">Кошелек получателя:</font>
</label></br>
<input name="nomer" plaсeholder="" style="height: 30px; width: 300px; font-size: 16px; font-family: Verdana"></br>
<br><input type="button" onclick="vuvod()" style="margin: 0 auto; float: none;" class="btn vuvod" value="ВЫВОД">
</center>
<br>
<br>
<center>
</td></br>
<td style="width: 20px">&nbsp;</td>
<td>
</br>
</td>
</tr>
</center>
</tbody></table>
</form>
</center>
<div class="panel-body">
                           

<script>
function cryptcahnge(){
    $("#countchange").val(parseFloat($("#change :selected").attr("dat")).toFixed(15));
    $("#countchange2").text(parseFloat($("#change :selected").attr("sum")));
    var name = $("#change :selected").text();
    $("#img").attr('src' ,"/ing/"+name+".png")
}
function cryptc(){
    $("#countchange2").text(parseFloat($("#change :selected").attr("price")*$("#countchange").val()*2.32).toFixed(15));
}

function vuvod(){
    var data =  $('#vuvod').serialize();
    $(".vuvod").attr("disabled", "disabled");
    $.ajax({
        type :"post",
        url: "/ajax/proc.php",
        data : data,
        success : function(html){ 
            alert(html)
            location.reload()
        }
    })
}

</script>
</div>
</div>



<div class="panel-body">
<div class="table-responsive">
<thead>
<tr>
<h2>История</h2>
<table class="table table-bordered  table-hover""  cellpadding="5" width="100%">
<center><tr style="background: #ccc">

<th><center>Сумма</center></th>
<th><center>Кошелек вывода</center></th>
<th><center>Валюта</center></th>
<th><center>Статус</center></th>
<th><center>Transaction</center></th>
</tr> </center>  
</tr>
</thead>

<tbody><center>
<?
$q = $mysql->prepare("SELECT * FROM db_vivod WHERE UserId = ? ORDER BY Uid DESC");
$q->execute(array($r['Id']));
$i = 1;
while($row = $q->fetch())
{
if(($q->rowCount() % 2) == 0) $st = 'odd'; 
else $st = 'even';
if($row['PaySystem'] == 'Bitcoin')
{
$val = 'BTC';
}
elseif($row['PaySystem'] == 'Dogecoin')
{
$val = 'DOGE';
}
switch($row['Status'])
{
case 1: $stt = '<center>Выплачено</center>'; break;
case 0: $stt = '<center>Обрабатывается</center>'; break;
}

?></center>
<tr class="<?=$st;?> gradeX">
<td><center> <img src="/images/coinswd.png"/> <?=$row['Summa'];?></center></td>
<td><center><?=$row['Purse'];?></center></td>
<td><center><?=$row['PaySystem'];?></center></td>
<!--td class="center"><a href="https://chain.so/tx/<?=$val;?>/<?=$row['Hash'];?>" target="_blank"><?=substr($row['Hash'], 0, 35);?></a></td-->
<td class="center"><?=$stt;?></td>
<center><td class="center"><!--a href="http://blockr.io/tx/info/<?=$row['Transaction'];?>" target="_blank"--><center><img src="/images/txs.png"/>  <?=$row['Transaction'];?></center></a></td></center>
</tr>
<? $i++; } ?>
</tbody>
</table>
</div>
</div>

<script>
function cryptcahnge(){
    $("#countchange").val(parseFloat($("#change :selected").attr("dat")).toFixed(15));
    $("#countchange2").text(parseFloat($("#change :selected").attr("sum")));
    var name = $("#change :selected").text();
    $("#img").attr('src' ,"/ing/"+name+".png")
}
function cryptc(){
    $("#countchange2").text(parseFloat($("#change :selected").attr("price")*$("#countchange").val()*2.32).toFixed(15));
}

function vuvod(){
    var data =  $('#vuvod').serialize();
    $(".vuvod").attr("disabled", "disabled");
    $.ajax({
        type :"post",
        url: "/ajax/proc.php",
        data : data,
        success : function(html){ 
            alert(html)
            location.reload()
        }
    })
}

</script>
</div>
</div>