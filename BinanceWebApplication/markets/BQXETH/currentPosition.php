<?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $timestamp = time()*1000;
    $params = "timestamp=$timestamp";
    $signiture = hash_hmac("sha256", $params, $secretKey);
    curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/account?$params&signature=$signiture");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    
    
    $headers = array();
    $headers[] = "X-Mbx-Apikey: $apiKey";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }
    $json = json_decode($result);
    $balances=array();
    for ($i=0; $i<sizeof($json->balances); $i++) {
        $coinWalletTest = $json->balances[$i]->asset;
        if ($coinWalletTest == $coin) {
           $coinAvailable = $json->balances[$i]->free;
        } elseif ($coinWalletTest == $pair) {
            $pairAvailable = $json->balances[$i]->free;
        }
        
    }
    curl_close ($ch);
?>
