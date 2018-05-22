<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}


?>

<?
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();




if(isset($_POST['mine']))
{
	$mine = intval($_POST['mine']);
	
	if($mine >= 1 and $mine <= 3)
	{
		if($r['ghs'] > 0)
		{
		$v = $mysql->prepare("UPDATE users SET Mine = ? WHERE Id = ?");
		$v->execute(array($mine, $_SESSION['id']));
		}
	}
	else
	{
		echo error("ERROR!!! Invalid item!");
	}
}
?>
<script type="text/javascript">
function mining(id){
    $.ajax({
        type:"POST",
        data: "id="+id,
        url:"/proc/mining.php",
        success: function () {
            location.reload()
        }
    })
}
$(document).ready(function () {
    var select = $('.miner').val();
    var renderPrice, renderCount, RenderSum,renderSpeed,cloudCount

    renderPrice = $("#"+select+"").find('#Price');
    renderSpeed = $('#speed').val();
    renderCount = $("#"+select+"").find('#Count');
	test = $("#"+select+"").find('#Titi');
    RenderSum = $("#"+select+"").find('#Cash');
	cloudCount = $('#cloud').val();
    
    if(select) {
        
        setInterval(function () {
            
			if(select == 'ghs')
			{
				test.val(parseFloat(renderSpeed)+ parseFloat(test.val()))
                renderCount.text(parseFloat(test.val()).toFixed(8))
                RenderSum.text(parseFloat(parseFloat(renderCount.text()) * parseFloat(renderPrice.text())).toFixed(8))
			}
			else
			{
				test.val(parseFloat(renderSpeed)+ parseFloat(test.val()))
                renderCount.text(parseFloat(test.val()).toFixed(8))
                RenderSum.text(parseFloat(parseFloat(renderCount.text()) * parseFloat(renderPrice.text())).toFixed(8))
			}
				
                
                
 
        } , 300)
    }
	


		
    
});
	

</script>

<?
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?"); 
$u->execute(array($_SESSION['id']));
$r = $u->fetch();
$okup = 60 * 60 * 24 * 300;
if($r['Mine'] != '')
{
	$countghs = $r['ghs']; // Кол-во GHS
	$speed = ($cfg['ghs'] / ($okup * $cfg[$r['Mine']])) * $countghs;
	$speed = sprintf("%01.15f", $speed);
}


?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">
    <link href="/theme/assets/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/theme/assets/libraries/owl.carousel/assets/owl.carousel.css" rel="stylesheet" type="text/css" >
    <link href="/theme/assets/libraries/colorbox/example1/colorbox.css" rel="stylesheet" type="text/css" >
    <link href="/theme/assets/libraries/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="/theme/assets/libraries/bootstrap-fileinput/fileinput.min.css" rel="stylesheet" type="text/css">
    <link href="/theme/assets/css/superlist.css" rel="stylesheet" type="text/css" >
    <link href="/css/animate.css" rel="stylesheet" type="text/css" >

    <link rel="shortcut icon" type="image/x-icon" href="/theme/assets/favicon.png">

    <title>Crypto-Mining24.com - Облачный майнинг</title>
	<script src="/theme/assets/jquery-1.11.3.min.js" type="text/javascript"></script>
</head>


<body>






    <div class="main">
        <div class="outer-admin">
            <div class="wrapper-admin">
                

                <div class="sidebar-secondary-admin"><br><br>
                   <center>
				   <a href="http://invest-continents.biz/?partner=alan"><img src="http://invest-continents.biz/images/IC-200.gif" alt="" width="200" height="300" /></a>
				   <br><br><br>
				   <a href="http://money-birds.su/?i=206"><img src="http://money-birds.su/images/MB-200.gif" border="0" /></a>
				   <br><br>
				   <a href="http://imonevo.pl/?ref=vitaliy"><img src="http://imonevo.pl/images/ME-200.gif" border="0" /></a>
				   <br><br>
				   <a href="http://ferma-rostok.ru/?ref=vitaliy"><img src="http://ferma-rostok.ru/img/diz/FR-200.gif" border="0" /></a>
				   <br><br>
				   <a href="http://seamoneybox.com/?ref=vitaliy" target="_blank"><img src="http://seamoneybox.com/images/banners/16.gif" border="0" alt="" /></a>
				   
				   </center>
                </div><!-- /.sidebar-secondary-admin -->

                <div class="content-admin">
                    <div class="content-admin-wrapper">
                        <div class="content-admin-main">
                            <div class="content-admin-main-inner">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12">
<div class="row">
<div class="col-sm-12">


<!--center>
<h1>Бонус 1 DogeCoin за 1 клик по рекламе <font color="red" size="4"><a href="/?a=bonus-reklama"><b><h1>>>Бонус<<</h1></b></a> </font></h1>
</center-->

<center>
<h3>
<b>Умнож депозит в 3-раза.</b><br>
Пополни баланс сейчас от 0.05 BTC вы получаете 0.15 BTC</h3>
<h4><b>А ТАКЖЕ <br>
Умнож депозит в 5-раза.</b><br>
 Пополни баланс сейчас от 0.15 BTC вы получаете 0.70 BTC</h4>
</center>

<center>
<a href="https://btc2x.com/?ref=hPg3d"><img src="/images/I6LZBW0FLRGZB.gif" /></a>
<a href="https://imonevo.pl/?ref=vitaliy"><img src="https://imonevo.pl/images/ME-468.gif" border="0" /></a>
</center>

<div id="div-1" class="body" style="padding: 20px 20px;">	

<h3>Здравствуйте, <?=$r['UsLogin']; ?>                                                 Ваш Email:<?=$r['Email'];?></h3>
	
<input type=hidden class=miner value=<?=$r['Mine']; ?>>
<input type=hidden id=speed value=<?=$speed; ?>>
<input type=hidden id=cloud value=<?=$r['ghs']; ?>>


<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/images/CM24.png" width="54" style=" width: 50px; margin: 0 15px 0 15px;"><br><font color="#E10000"><b>CM24</b></font><br>
<div id="ghs">
<input type=hidden id=Titi value=<?=$r['ghs']; ?>>	
Count: <span id="Count"><?=sprintf("%01.8f", $r['ghs']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.2f", $ghs); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['ghs'] * $ghs)); ?></span><br>
<center>
<div onclick="mining('10');" class="butmine" id="mine-btc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'ghs') echo 'background-color:#000000; border-radius: 8px;'; ?> cursor:pointer;"></div>
</center>
</div>
</div>
</div> 

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/btc.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>BitCoin</b></font><br>
<div id="btc">
<input type=hidden id=Titi value=<?=$r['btc']; ?>>	
Count: <span id="Count"><?=sprintf("%01.8f", $r['btc']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.2f", $cfg['btc']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['btc'] * $cfg['btc'])); ?></span><br>
<center>
<div onclick="mining('1');" class="butmine" id="mine-btc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'btc') echo 'background-color:#000000; border-radius: 8px;'; ?> cursor:pointer;"></div>
</center>
</div>
</div>
</div> 

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/ltc.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>LiteCoin</b></font><br>
<div id="ltc">
<input type=hidden id=Titi value=<?=$r['ltc']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['ltc']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.2f", $cfg['ltc']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['ltc'] * $cfg['ltc'])); ?></span><br>
<center>
<div onclick="mining('2');" class="butmine" id="mine-ltc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'ltc') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div>
</center>
</div>
</div>
</div>
 
<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/doge.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>DogeCoin</b></font><br>
<div id="doge">
<input type=hidden id=Titi value=<?=$r['doge']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['doge']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['doge']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['doge'] * $cfg['doge'])); ?></span><br>
<center>
<div onclick="mining('3');" class="butmine" id="mine-doge" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'doge') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div></center>
</div>
</div>
</div>   	

<center>
<a href="http://invest-continents.biz/?partner=alan"><img src="http://invest-continents.biz/images/468.gif" alt="" width="468" height="60" /></a>
<a href="http://www.ethereumfaucet.net/index.php?r=0x1c9c20c9b15ef2bd11783f5bae85f77fc1dd36af"><img src="/images/EthereumFaucer.gif" /></a>
</center><br>


<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/blk.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>BlackCoin</b></font><br>
<div id="blk">
<input type=hidden id=Titi value=<?=$r['blk']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['blk']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['blk']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['blk'] * $cfg['blk'])); ?></span><br>
<center>
<div onclick="mining('4');" class="butmine" id="mine-blk" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'blk') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div>
</center>
</div>
</div>
</div>

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/dash.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>DashCoin</b></font><br>
<div id="dash">
<input type=hidden id=Titi value=<?=$r['dash']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['dash']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['dash']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['dash'] * $cfg['dash'])); ?></span><br>
<center>
<div onclick="mining('5');" class="butmine" id="mine-dash" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'dash') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div></center>
</dIV>
</div>
</div> 	 

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/nmc.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>NameCoin</b></font><br>
<div id="nmc">
<input type=hidden id=Titi value=<?=$r['nmc']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['nmc']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['nmc']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['nmc'] * $cfg['nmc'])); ?></span><br>
<center>
<div onclick="mining('6');" class="butmine" id="mine-nmc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'nmc') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div></center>
</div>
</div>
</div> 				

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/crypto/ppc.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>PeerCoin</b></font><br>
<div id="ppc">
<input type=hidden id=Titi value=<?=$r['ppc']; ?>>								
Count:<span id="Count"><?=sprintf("%01.8f", $r['ppc']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['ppc']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['ppc'] * $cfg['ppc'])); ?></span><br>
<center>
<div onclick="mining('7');" class="butmine" id="mine-ppc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'ppc') echo 'background-color:#000000; border-radius: 8px;'; ?> cursor:pointer;"></div></center>
</div>
</div>
</div>


<center>
<a target="_blank" href="http://www.etherfaucet.net/?r=0x1c9c20c9b15ef2bd11783f5bae85f77fc1dd36af"><img src="http://www.etherfaucet.net/images/refer/728x90.png" width="728px" height="90px" /></a>
</center><br>


<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/ing/Ethereum.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>Ethereum</b></font><br>
<div id="eth">
<input type=hidden id=Titi value=<?=$r['eth']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['eth']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['eth']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['eth'] * $cfg['eth'])); ?></span><br>
<center>
<div onclick="mining('9');" class="butmine" id="mine-eth" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'eth') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div></center>
</dIV>
</div>
</div> 	 

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/ing/Clam.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>Clam</b></font><br>
<div id="clam">
<input type=hidden id=Titi value=<?=$r['clam']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['clam']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['clam']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['clam'] * $cfg['clam'])); ?></span><br>
<center>
<div onclick="mining('11');" class="butmine" id="mine-clam" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'clam') echo 'background-color:#000000; border-radius: 8px;'; ?>  cursor:pointer;"></div></center>
</div>
</div>
</div> 				

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/ing/Reddcoin.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>ReddCoin</b></font><br>
<div id="rdd">
<input type=hidden id=Titi value=<?=$r['rdd']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['rdd']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['rdd']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['rdd'] * $cfg['rdd'])); ?></span><br>
<center>
<div onclick="mining('12');" class="butmine" id="mine-rdd" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'rdd') echo 'background-color:#000000; border-radius: 8px;'; ?> cursor:pointer;"></div></center>
</div>
</div>
</div>

<div class="col-lg-3">
<div class="alert alert-danger text-center" style="background-color:#337ab7;">
<img src="/ing/Feathercoin.png" width="54" style=" margin: 0 15px 0 15px;"><br><font color="#E10000"><b>FeatherCoin</b></font><br>
<div id="ftc">
<input type=hidden id=Titi value=<?=$r['ftc']; ?>>								
Count: <span id="Count"><?=sprintf("%01.8f", $r['ftc']); ?></span></br>
Price $: <span id="Price"><?=sprintf("%01.5f", $cfg['ftc']); ?></span></br>
Cash $: <span id="Cash"><?=sprintf("%01.8f", ($r['ftc'] * $cfg['ftc'])); ?></span><br>
<center>
<div onclick="mining('13');" class="butmine" id="mine-ftc" style="background:url(/crypto/ma.png)no-repeat; width:100px; height:50px; border: 0px solid red; <? if($r['Mine'] == 'ftc') echo 'background-color:#000000; border-radius: 8px;'; ?> cursor:pointer;"></div></center>
</div>
</div>
</div></div></div>



<center>
<a href="http://product-game.ru/?ref=vadim" target="_blank"><img src="http://product-game.ru/images/banners/728x90.gif"></a>
<!--Start BitMedia.io code-->
<a href="https://bitmedia.io/?r=wAeuuywZsn">
  <img src="//promo.bitmedia.io/bm_pr_72890.gif"/>
</a>
<!--End BitMedia.io code-->
</center>

<div class="clearfix"></div>
			  </div>
			</div>
		  </div>
		</div>
	</div>
  </div>
</div>
<br />