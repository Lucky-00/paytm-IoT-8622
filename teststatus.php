<?php

require_once("./lib/encdec_paytm.php");



define("MERCHANT_MID", "xxxxxxxxxxxxxxx");

define("MERCHANT_KEY", "xxxxxxxxxxxxxxx");



$paytmParams = array();

$paytmParams["body"] = array(

"mid" => MERCHANT_MID,

"linkId" => "81",

"pageNo" => "1",

"pageSize" => "20",

"searchStartDate" => "25/03/2019",

"searchEndDate" => "10/04/2019"

);

$checksum = getChecksumFromString(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), MERCHANT_KEY);

$paytmParams["head"] = array(

"timestamp" => time(),

"clientId" => "XXX",

"version" => "v1",

"channelId" => "WEB",

"tokenType" => "XXX",

"signature" => $checksum

);



$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);



// for staging

$url = "https://securegw-stage.paytm.in/link/fetchTransaction";

// for production

// $url = "https://securegw.paytm.in/link/fetchTransaction";



$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 

$response = curl_exec($ch);
