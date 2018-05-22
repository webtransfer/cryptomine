<?php

function api_query($method, array $req = array()) {
        // API settings
        $key = 'c6f5edff34b1dd27b09119bb210ebca83e563dcd'; // your API-key
        $secret = '38501b4d9d088f625bf523b9c6612333f3d9cd7b41af1ce26cbd25dac98c9d0c93e167e24ea2433d'; // your Secret-key
 
        $req['method'] = $method;
        $mt = explode(' ', microtime());
        $req['nonce'] = $mt[1];
       
        // generate the POST data string
        $post_data = http_build_query($req, '', '&');

        $sign = hash_hmac("sha512", $post_data, $secret);
 
        // generate the extra headers
        $headers = array(
                'Sign: '.$sign,
                'Key: '.$key,
        );
 
        // our curl handle (initialize if required)
        static $ch = null;
        if (is_null($ch)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; CoinWallet.co PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        }
        curl_setopt($ch, CURLOPT_URL, 'https://www.coinwallet.co/api/');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
        // run the query
        $res = curl_exec($ch);

        if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
        $dec = json_decode($res, true);
        if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
        return $dec;
}


 
//$result = api_query("getcurrencies");

#$result = api_query("getbalance", array("currency_id" => 1));

#$result = api_query("getreceived", array("currency_id" => 1, "limit" => 200));

#$result = api_query("getsent", array("currency_id" => 1, "limit" => 200));

#$result = api_query("sendpayment", array("currency_id" => 1, "target_address" => "MFye1P5uxpJURbTPHYkGxSiZJqiV2UbKdQ", "send_value" => "10"));

#$result = api_query("getnewaddress", array("currency_id" => 1));

//echo "<pre>".print_r($result, true)."</pre>";
?>