<footer>
<div class="container widget">
<div class="row">
<div class="col-sm-6 col-lg-3">
<h3 class="footer-title">Статистика</h3>
<ul class="list-unstyled contact-info">
                       
<?
$q = $mysql->query("SELECT Uid FROM users");
$w = $mysql->query("SELECT SUM(ghs) AS Ghs FROM users");
$e = $w->fetch();
$btc = $mysql->query("SELECT SUM(btc) AS btc");
?>
<li><i class="icon-ok-circled2"></i><a>Пользователей: <?=$q->rowCount();?></a>  </li>
<li><i class="icon-ok-circled2"></i><a>Купленно CM24: <?=sprintf("%01.2f", $e['Ghs']);?></a>  </li>
<li><i class="icon-ok-circled2"></i><a>1 CM24 = </abbr> 1 USD</a>  </li>
</ul>



</div>
<div class="col-sm-6 col-lg-3">
<h3 class="footer-title">Цены крипто валют</h3>
<ul class="list-unstyled contact-info">
<li><i class="icon-ok-circled2"></i><a>BitCoin = <?=sprintf("%01.2f", $cfg['btc']); ?> $</a>  </li>
<li><i class="icon-ok-circled2"></i><a>LiteCoin = <?=sprintf("%01.2f", $cfg['ltc']); ?> $</a> </li>
<li><i class="icon-ok-circled2"></i><a>DogeCoin = <?=sprintf("%01.5f", $cfg['doge']); ?> $</a> </li>
<li><i class="icon-ok-circled2"></i><a>DashCoin = <?=sprintf("%01.5f", $cfg['dash']); ?> $</a> </li>
<!--li><i class="icon-ok-circled2"></i><a>BlackCoin = <?=sprintf("%01.5f", $cfg['blk']); ?> $</a> </li>
<li><i class="icon-ok-circled2"></i><a>NameCoin = <?=sprintf("%01.5f", $cfg['nmc']); ?> $</a> </li-->
</ul>
</div>

<div class="col-sm-6 col-lg-3">
<h3 class="footer-title">КОНТАКТЫ</h3>
<p>Tel: 9892-62156 int 6126</p>
<p>Address: Company Crypto-Mining24</p>
<p>Mail: support@Crypto-Mining24.com</p>
</div>

<div class="col-sm-6 col-lg-3">
<h3 class="footer-title">Мы принимаем</h3>

<ul class="pay list-unstyled">

<img src="/ing/BitCoin.png" width="29"  height="29"  />
<img src="/ing/BlackCoin.png" width="29"  height="29"  />
<img src="/ing/DashCoin.png" width="29"  height="29"  />
<img src="/ing/Dogecoin.png" width="29"  height="29"  />
<img src="/ing/EmerCoin.png" width="29"  height="29"  />
<img src="/ing/Litecoin.png" width="29"  height="29"  />
<img src="/ing/PayCoin.png" width="29"  height="29"  />
<img src="/ing/PeerCoin.png" width="29"  height="29"  />
<img src="/ing/PrimeCoin.png" width="29"  height="29"  />
<img src="/ing/ReddCoin.png" width="29"  height="29"  />
<img src="/ing/VertCoin.png" width="29"  height="29"  />
<img src="/ing/Ethereum.png" width="29"  height="29"  />
<img src="/ing/Gridcoin.png" width="29"  height="29"  />
<img src="/ing/Feathercoin.png" width="29"  height="29"  />
<img src="/ing/Clam.png" width="29"  height="29"  />

</ul>
</div>
</div>
</div>

<div class="copyright text-center">
<div class="container">
<h6 class="col-xs-12 col-lg-6">© 2016 All rights Crypto-Mining24.</h6>
<ul class="list-unstyled col-xs-12 col-lg-6 social">
<li class="tooltip_hover" title="vimeo" data-placement="top"  data-toggle="tooltip"><a href="#"><i class="icon-vimeo"></i></a></li>
<li class="tooltip_hover" title="twitter" data-placement="top"  data-toggle="tooltip"><a href="#"><i class="icon-twitter"></i></a></li>
<li class="tooltip_hover" title="gplus" data-placement="top"  data-toggle="tooltip"><a  href="#" ><i class="icon-gplus"></i></a></li>
<li class="tooltip_hover" title="in" data-placement="top"  data-toggle="tooltip"><a href="#"><i class="icon-linkedin"></i></a></li>
<li class="tooltip_hover" title="play" data-placement="top"  data-toggle="tooltip"><a href="#"><i class="icon-next"></i></a></li>
<li class="tooltip_hover" title="pinterest" data-placement="top"  data-toggle="tooltip"><a href="#"><i class="icon-pinterest"></i></a></li>
</ul>
</div>
</div>

    </footer>
    <!--Footer-->


    <!-- ======================= JQuery libs =========================== -->
    	<!-- Jquery -->
	    <script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>

	    <!-- Bootstrap -->
	    <script src="/demo2/js/bootstrap.min.js" type="text/javascript"></script>
	    
	    <!--snap-->
	    <script src="/demo2/js/snap/snap.js"></script>

	    <!-- Video Responsive-->
	    <script src="/demo2/js/fitvids/jquery.fitvids.js"></script>
        <script src="/demo2/js/jquery.placeholder.min.js"></script>

        <!-- Scroll nav -->
        <script src="/demo2/js/nav/jquery.scrollTo.js"></script> 
        <script src="/demo2/js/nav/jquery.nav.js"></script> 

	    <!--WayPoint-->
	    <script src="/demo2/js/waypoint/waypoints.js"></script>

        <!-- Twitter -->
        <script src="/demo2/twitter/jquery.tweet.min.js"></script>

	    <!-- Custom -->
	    <script type="text/javascript" src="/js/jquery-func.js"></script>

    <!-- ======================= JQuery libs =========================== -->


	<?
	if(isset($_SESSION['id']))
	{
	?>

	


	<? } ?>
</div>
</div>
</div>
</body>