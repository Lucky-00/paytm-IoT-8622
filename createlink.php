<?php

require_once("./lib/encdec_paytm.php");



define("MERCHANT_MID", "xxxxxxxxxxxxxxx");

define("MERCHANT_KEY", "xxxxxxxxxxxxxxx");



$paytmParams = array();

$paytmParams["body"] = array(

//"merchantRequestId" => "lucky123456789",

"mid" => MERCHANT_MID,

"linkName" => "AutomatedVendor",

"linkDescription" => " some crap about the product",

"linkType" => "FIXED",

"amount" => "1",

"expiryDate" => "10/09/2019",

"isActive" => "true",

"sendSms" => "true",

"customerContact" => array(

"customerName" => "Wont use this feature",

"customerMobile" => "xxxxxxxxxx"

)

);

$checksum = getChecksumFromString(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), MERCHANT_KEY);

$paytmParams["head"] = array(

"timestamp" => time(),

//"clientId" => "lu123",

"version" => "v1",

"channelId" => "WEB",

"tokenType" => "AES",

"signature" => $checksum

);



$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);



// for staging

//$url = "https://securegw-stage.paytm.in/link/create";

// for production

  $url = "https://securegw.paytm.in/link/create";



$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 

$response = curl_exec($ch);

//echo($post_data);

echo($response);

echo("I am not printing aything below this");





?>
