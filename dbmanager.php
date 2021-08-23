<?php
date_default_timezone_set("Asia/Kolkata");

$json = '{ "body": { "resultInfo": { "resultCode": "200", "resultMessage": "Payment link is processed successfully", "resultStatus": "SUCCESS" }, "merchantId": "xxxxxxxxxxxxxxxxxxxxxx", "merchantName": "", "orders": [{ "customerName": "", "customerPhoneNumber": "xxxxxxxxxx", "mercUniqRef": "INV_lok2037", "orderCompletedTime": "08/04/2019 13:41:12", "orderCreatedTime": "08/04/2019 13:41:01", "orderId": "201904081340590010", "orderStatus": "SUCCESS", "orderType": "ACQUIRING", "txnAmount": 1.0, "txnId": "20190408111212800110168302600429785" }, { "customerName": "", "customerPhoneNumber": "xxxxxxxxxx", "mercUniqRef": "INV_lok2037", "orderCompletedTime": "08/04/2019 13:41:12", "orderCreatedTime": "08/04/2019 13:41:01", "orderId": "201904081340590010", "orderStatus": "SUCCESS", "orderType": "ACQUIRING", "txnAmount": 1.0, "txnId": "30190408111212800110168302600429785" } ] }, "head": { "channelId": "WEB", "clientId": "XXX", "signature": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx", "timestamp": "xxxxxxxxxx", "tokenType": "XXX", "version": "v1" } }';




$client = json_decode($json);


echo count($client -> body -> orders)."<p>";

echo $client -> body -> orders[0] -> txnId;
echo "<p>".date('d-m-Y h:i:s');
?>