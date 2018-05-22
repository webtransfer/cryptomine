<?php

// check status of invoice - accept payment
// that function must bee call after receive backcall from service:
//   1. service note to http://SHOP_URL/NOTE_URL .. bill=bill_id&order=order_id - that invoice status is changed
//   2. you script call check_status($bill, $status_for_accept);
function check_status($bill_key, $st_wait) {
	
	// check via API
	$curl=curl_init('http://LITE.cash/api_bill/check.json/'.$bill_key);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_TIMEOUT,5);
	curl_setopt($curl,CURLOPT_HEADER,0);
	$result = curl_exec($curl);
	//p($result);
	
	$result=json_decode($result);
	//p($result);
	
	if (isset($result->error)) return $result->error;
	if (isset($result->status))
	{
		$st = $result->status;

		if ($st=='CLOSED'
				|| $st=='HARD' && ($st_wait=='HARD' || $st_wait=='SOFT')
				|| $st=='SOFT' && $st_wait=='SOFT'
				) return 1; // paid
		elseif ($st=='NEW' || $st=='FILL') return 0; // awaiting
		else return -1; // expired or invalid
	}
}
?>