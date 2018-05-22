<?php

define('LIB_name', 'LITE.cash');

function get_lib_settings_list() {
	return array (
		'merchant_id' => '', // shop ID from service
		'merchant_addr' => '', //  bitcoin (etc. crypto) address for quick registration
		'icon_url' => '',	 // for quick registration
		'order_status_id' => '', // set this order status when order paid
		'expire_bill' => '', // minutes expired
		'on_bill_status' => 'HARD', // on that status accept payment
		'currencies_allowed' => '', // allow currencies for payment
		'currency_payout' => 'not_convert', // currency for payouts
		'public_order' => '', // =1 if public
		'default_deposit' => 10, // for fund account deposit - default amount
		'bonus' => 1.0, // if selected this payment method - take a bonus
		'additional_pars' => '' // some additional pars (see API)
		);
}

// make request for automatic registration
function lib_quick_reg($reg_addr, $reg_pars) {
	$reg_url = 'http://lite.cash/api/quick_reg.json/'.$reg_addr.
		'?' . http_build_query( $reg_pars );
	$curl=curl_init( $reg_url );
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_TIMEOUT,25);
	curl_setopt($curl,CURLOPT_HEADER,0);
	return curl_exec($curl);
}

?>