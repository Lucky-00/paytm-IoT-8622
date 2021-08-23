
<meta http-equiv="refresh" content="5">
<?php

require_once("./lib/encdec_paytm.php");
require_once("login.php");

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
$paytmresponse = curl_exec($ch);

echo($paytmresponse);


$response = json_decode($paytmresponse);

$name =   $response -> body -> orders[0] -> customerName;
$phone =   $response -> body -> orders[0] -> customerPhoneNumber;
$email =   $response -> body -> orders[0] -> customerEmail;
$txnamount =   $response -> body -> orders[0] -> txnAmount;
$txnid     =   $response -> body -> orders[0] -> txnId;
$ordcreatedtime   =  date('Y-m-d H:i:s', strtotime($response -> body -> orders[0] -> orderCompletedTime)) ;
$ordcompletedtime   =   date('Y-m-d H:i:s', strtotime($response -> body -> orders[0] -> orderCreatedTime));
$paytmresponsetime  =  date('Y-m-d H:i:s', intval(($response -> head -> timestamp/1000)));

//$paytmresponsetime =   gmdate('Y-m-d H:i:s', intval($response -> head -> timestamp));

$conndbserver = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($conndbserver->connect_error) {
    die($conndbserver-> connect_error); //replace with some shit!
}

echo "Connected successfully";

/*$conndbserver->query("SET SESSION time_zone= '+5:30'"); // use when woking with entries retrieved from database, 
                                                              as the 'entrydate' column in db holds the timestamp
                                                              at which the data is added, may not work!*/
                                                            
$sql = "INSERT INTO verifiedcustomer(name, phone, email, txnamount, txnid, ordcreatedtime, ordcompletedtime, paytmresponsetime) 
VALUES ('$name', $phone, '$email', $txnamount, '$txnid', '$ordcreatedtime', '$ordcompletedtime', '$paytmresponsetime')";


if ($conndbserver-> query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conndbserver->error;
}

echo "<p>".date('d-m-Y h:i:s');

$conndbserver->close();

?>
