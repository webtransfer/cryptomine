<?
if(!isset($_SESSION['id']))
{
	Header("Location: /");
	exit;
}
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();

?>
<div class="content_fullwidth less1">
<div class="container">	
<center><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script><script src="//catcut.net/adv/4656"></script></center>
<center><h1 class="light sm-text-center">Внутренняя система обмена</h1>
<h5>Обмен на внутреннюю валюту CM24 осуществляется моментально.</h5></center>
<br>

<form action="/?a=exchange" method="post" id="ex">
	
<div class="row">
<div class="col-sm-3" >
<div class="form-group form-group-default">
<img id="img" alt="" src="/ing/Select.png" height="80" style="display: block; margin: 0 auto 11px;  ">
</div>
</div>

<div class="col-sm-3" >
<div class="form-group">
<select class="form-control" style="height:40px; width:100%;" name="cryptidex" onchange="cryptcahnge()" id="change">

<option style="align:center;">Выбрать валюту</option>
<option data-price="<?=$cfg['btc'];?>" sum="<?=sprintf("%01.15f", ($cfg['btc'] * $r['btc']) * $ghs);?>" dat="<?=$r['btc'];?>" value="3">BitCoin</option>
<option data-price="<?=$cfg['ltc'];?>" sum="<?=sprintf("%01.15f", ($cfg['ltc'] * $r['ltc']) * $ghs);?>" dat="<?=$r['ltc'];?>" value="4">LiteCoin</option>
<option data-price="<?=$cfg['doge'];?>" sum="<?=sprintf("%01.15f", ($cfg['doge'] * $r['doge']) * $ghs);?>" dat="<?=$r['doge'];?>" value="5">DogeCoin</option>
<option data-price="<?=$cfg['dash'];?>" sum="<?=sprintf("%01.15f", ($cfg['dash'] * $r['dash']) * $ghs);?>" dat="<?=$r['dash'];?>" value="6">DashCoin</option>
<option data-price="<?=$cfg['blk'];?>" sum="<?=sprintf("%01.15f", ($cfg['blk'] * $r['blk']) * $ghs);?>" dat="<?=$r['blk'];?>" value="7">BlackCoin</option>
<option data-price="<?=$cfg['ppc'];?>" sum="<?=sprintf("%01.15f", ($cfg['ppc'] * $r['ppc']) * $ghs);?>" dat="<?=$r['ppc'];?>" value="14">PeerCoin</option>
<option data-price="<?=$cfg['nmc'];?>" sum="<?=sprintf("%01.15f", ($cfg['nmc'] * $r['nmc']) * $ghs);?>" dat="<?=$r['nmc'];?>" value="10">NameCoin</option>
		
<option data-price="<?=$cfg['eth'];?>" sum="<?=sprintf("%01.15f", ($cfg['eth'] * $r['eth']) * $ghs);?>" dat="<?=$r['eth'];?>" value="9">Ethereum</option>
<option data-price="<?=$cfg['clam'];?>" sum="<?=sprintf("%01.15f", ($cfg['clam'] * $r['clam']) * $ghs);?>" dat="<?=$r['clam'];?>" value="11">Clam</option>
<option data-price="<?=$cfg['rdd'];?>" sum="<?=sprintf("%01.15f", ($cfg['rdd'] * $r['rdd']) * $ghs);?>" dat="<?=$r['rdd'];?>" value="12">ReddCoin</option>
<option data-price="<?=$cfg['ftc'];?>" sum="<?=sprintf("%01.15f", ($cfg['ftc'] * $r['ftc']) * $ghs);?>" dat="<?=$r['ftc'];?>" value="13">Feathercoin</option>		
		
		
</select>   
</div>


<div class="form-group form-group-default">
<label><img src="/ing/coinswd.png"> :</label>

<input type="text" onchange="cryptc()" name="count" value="<?=$r['btc'];?>" id="countchange" class="form-control">

</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default">
<img src="/ing/CM24.png" height="80"style="display: block; margin: 0 auto 11px;  "/>
</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default">
<img src="/ing/Lightning-16.png"> CM24:<span id="countchange2"><?=sprintf("%01.15f", ($cfg['btc'] * $r['btc']) * $ghs);?></span>
</div>

<div >

<input type="submit" onclick="ex()" class="btn btn-complete btn-cons" value="Обмен" />


</div>
</div>
</div>
</div>			
</form>

<hr />

<script>
function cryptcahnge(){
    $("#countchange").val(parseFloat($("#change :selected").attr("dat")).toFixed(15));
    $("#countchange2").text(parseFloat($("#change :selected").attr("sum")).toFixed(15));
    var name = $("#change :selected").text();
    $("#img").attr('src' ,"/ing/"+name+".png")
}
function cryptc(){
    $("#countchange2").text(parseFloat($("#change :selected").attr("price")*$("#countchange").val()).toFixed(15));
}

function ex(){
  $(".obmen").attr("disabled", "disabled");
    var data = $("#ex").serialize();
    $.ajax({
        type: 'post',
        url: "/ajax/proc.php",
        data: data,
        success: function(html){
            alert(html);
            location.reload()
        }
    })
}

</script>