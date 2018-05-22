<?
$u = $mysql->prepare("SELECT * FROM users WHERE Id = ?");
$u->execute(array($_SESSION['id']));
$r = $u->fetch();
?>				
<div class="content_fullwidth less1">
<div class="container">		
<center>
<center>
<script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script>
</center>

<center>
<script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script><script src="//catcut.net/adv/4556"></script>
</center>

<h3>За каждого приглошонного вами реферала вам начисляется 10 DogeCoin на баланс</h3>

				<h3>Ваша реферальная ссылка:<br> http://<?=$_SERVER['HTTP_HOST'];?>/?ref=<?=$r['Uid'];?></h3>
				
				<br><br>
				<img src="/images/banner468.gif"><br>
				<br>
				<textarea rows="3" cols="60"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/?ref=<?=$r['Uid'];?>" target=_blank><img src="http://<?=$_SERVER['HTTP_HOST'];?>/images/banner468.gif"></a></textarea>
				<br>
				
				<div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Uid</th>
                                            <th>E-Mail</th>
											<th>Бонус</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
									$q = $mysql->prepare("SELECT * FROM users WHERE RefId = ?");
									$q->execute(array($r['Uid']));
									$q->execute(array(10, $reff));
									while($row = $q->fetch())
									{
										if(($q->rowCount() % 2) == 0) $st = 'odd'; 
										else $st = 'even';
									?>
                                        <tr class="<?=$st;?> gradeX">
                                        <td><?=$row['Uid']; ?></td>
                                        <td><?=$row['Email'];?></td>
										<td>10  DogeCoin </td>
                                           
                                            
                                        </tr>
									<? } ?>
                                        
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
				</center>
				</div>
                </div>