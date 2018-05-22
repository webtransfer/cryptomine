 <?
 if(isset($_POST['go']))
 {
	$email = clean($_POST['email']);
	$name = clean($_POST['name']);
	$text = clean($_POST['text']);
	include($_SERVER['DOCUMENT_ROOT']."/libmail.php");
	$m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
	$m->From( $name.";".$email ); // от кого Можно использовать имя, отделяется точкой с запятой
	$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
	//$m->To( "Robot;e-income.vv.si@mail.ru" );   // кому, в этом поле так же разрешено указывать имя
	$m->Subject( "Support Crypto-Mine.com" );
	$m->Body("Text Message:<br> <b>".$text."</b>", "html");
	$m->Priority(4) ;	// установка приоритета
	$m->Send();	// отправка
	echo success('Your message has been sent successfully');
	Header("Refresh: 2, /support");
 }
 ?>

<div class="content_fullwidth less2">
<div class="container">	  
 <!-- Contact Form Start -->
<div style="margin: 20px 20px;">
<b>info@Crypto-Mine.com</b>
<center>



<iframe data-aa='109720' src='https://ad.a-ads.com/109720?size=468x60' scrolling='no' style='width:468px; height:60px; border:0px; padding:0;overflow:hidden' allowtransparency='true' frameborder='0'></iframe>

</center>
                                  <h2 class="page-header">Техническая поддержка</h2>
                                  <form action="" method="post" class="form bg-clouds padding-top20 padding-bottom20">
                                      <div class="row">
                                        <div class="form-group">
                                          <div class="col-md-6">
                                            <label>Ваше имя *</label>
                                            <input type="text" id="name" name="name" class="form-control" maxlength="100" value="">
                                          </div>
                                          <div class="col-md-6">
                                            <label>Ваш E-Mail адрес *</label>
                                            <input type="email" id="email" name="email" class="form-control" maxlength="100" value="">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                              <label>Текст обращения *</label>
                                              <textarea style="height: 110px;" id="text" name="text" class="form-control" rows="10" maxlength="5000"></textarea>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row top30 bottom20">
                                        <div class="col-md-12">
                                          <input name="go" type="submit" data-loading-text="Loading..." class="btn btn-primary btn" value="Отправить">
                                        </div>
                                      </div>                    
                                  </form>
                                <!-- Contact Form end -->
								</div>
								 </div>
                                      </div>