<?
//ID 186
function lib_quick_reg($reg_addr, $reg_pars) {
	$reg_url = 'http://lite.cash/api/quick_reg.json/'.$reg_addr.
		'?' . http_build_query( $reg_pars );
	$curl=curl_init( $reg_url );
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_TIMEOUT,25);
	curl_setopt($curl,CURLOPT_HEADER,0);
	return curl_exec($curl);
}


$reg_pars = array(
	'shop_url' => 'http://crypto-mine.com',
	'icon_url' => 'http://crypto-mine.com',
	'email'    => 'e-income.vv.si@mail.ru',
	'note_url' => 'status.php',
	'back_url' => 'index.php'
	);
	
	$res = lib_quick_reg('1KuiV5xhMCe5sQFAphyqvD8fkLCsRPsnRZ', $reg_pars);
	var_dump($res);