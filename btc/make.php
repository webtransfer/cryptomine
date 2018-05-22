<?php

// after select this payment method call:
// make_order_bill($order_info)
//

function _g($o,$k,$v=false) {
	return (isset($o[$k])?$o[$k]:$v);
}

// parameters for make bill
function get_lib_args_list() {
	return array (
		'shop', // Shop ID from service or crypto-currency wallet address
		'order', // order_id from this shop
		'price', // order price
		'curr', // currency of price
		'conv_curr', // convert into currency
		'not_convert', // not convert payments
		'curr_in', // only in that currencies may be payment
		'curr_in_stop', // not receive that currencies
		'vol', // default amount for bills with zero price - for example, deposit accounts
		'expire', // in minutes - bill will expired
		'public', // if set - bill is public else is secret
		'note_on', // notificate the shop only on this bill status
		'back_url', // for return to shop site in order details
		'lang', // translate in = en, ru, ...
		'exchanging', // set =1 if that exchange operation
		'email' // for auto registration
		);
}

// make url	
function make_bill_url($info) {
	// parameters: price, order, curr, ...
	// if need make a deposit bill - add 'DEP' to order_id. for example:
	//           { merchant_id, price = 0, order_id = DEP123, curr = 'BTC',
	//	           default_deposit=1}

	$merchant_id = $info['merchant_id'];
	$order = $info['order_id'];
	$conv = $info['currency_payout'];
	if ($conv == 'AS_IS') {
		$conv = '';
	} else {
		if ($conv == 'not_convert') {
			// do not convert incoming payments
			$conv = '&not_convert';
		} else {
			// 
			$conv = '&conv_curr=' . $conv;
		}
	}
	
	$price = _g($info,'price', 0);
	$expr = $back_url = '';
	if ($price>0) {
		$expr = intval($info['expire_bill']);
		if ($expr>10) {
			$expr = '&expire='.$expr;
		} else {
			$expr = '';
		}
	} else {
		// back URL for return to shop on this order details
		$back_url = '&' . http_build_query(array(
					// add "deposit" parameter in back URL 
					'back_url' => 'deposit='. $order,
					'vol' => $info['default_deposit']
				)
			);
		
	}
	
	// as array
	$currencies_allowed = $info['currencies_allowed'];
	
	//
	$m_url = 'http://LITE.cash/api_bill/make.json/'.$merchant_id.
		'?order='.$order.
		$conv . $expr.
		($info['public_order']?'&public':'').
		trim($info['additional_pars']).
		'&curr='.$info['curr'].
		'&price='.$price.
		(is_array($currencies_allowed)?join('',array_map(function($currencies_allowed)
				{return '&curr_in='.$currencies_allowed;}, $currencies_allowed)):'').
		$back_url;
	return $m_url;
}

// make bill for that order
function make_order_bill($order_info) {

	$m_url = make_bill_url($order_info);
	$curl=curl_init( $m_url );
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_TIMEOUT,35);
	curl_setopt($curl,CURLOPT_HEADER,0);
	$result = curl_exec($curl);

	if (empty($result)) {
		$error = 'LITEcash - make_order_bill: connection lost';
		return [$error, NULL];
	}

	$res_decoded = json_decode($result);

	if ($res_decoded) {
		// it is array - that is error
		if (isset($res_decoded->error)) {
			return [$res_decoded->error, NULL];
		} else {
			return [$result, NULL];
		}
	} else {
		$bill_id = (int)$result;
		if (!isset($bill_id)) {
			// number not exist - error
			return [$result, NULL];
		}
		// return bill_id + secret key
		return [NULL, $result];
	}
}
?>