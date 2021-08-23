<?php

require_once("./lib/encdec_paytm.php");



date_default_timezone_set("Asia/Kolkata");



define("MERCHANT_MID", "xxxxxxxxxxxxxxx");

define("MERCHANT_KEY", "xxxxxxxxxxxxxxx");



$datetoday = strval(date("d/m/Y"));

$paytmParams = array();

$paytmParams["body"] = array(

"mid" => MERCHANT_MID,

"linkId" => "xxxxxxxxxxxxxxx",

"searchStartDate" => "05/09/2019",

"searchEndDate" => "05/09/2019"

//"searchStartDate" => $datetoday,

//"searchEndDate" => $datetoday

);



$checksum = getChecksumFromString(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), MERCHANT_KEY);

$paytmParams["head"] = array(

"timestamp" => time(),

"channelId" => "WEB",

"tokenType" => "AES",

"signature" => $checksum

);



$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);



// for staging

// $url = "https://securegw-stage.paytm.in/link/fetchTransaction";

// for production

 $url = "https://securegw.paytm.in/link/fetchTransaction";



$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 

$response = curl_exec($ch);

echo($response);

?>
