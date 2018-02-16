<?php
$access_token = 'fXyMjt64aoCzQRVOOVmvIIkq5ZM7AqanE13iuh4wyUdbjxlkz2az3h6rvum9SZBwTCY/rqjfMqhFxsms/BSn1cAa/ixWRuD6/ZYYHN0NpIsqk3puoDOjWsIf2UDT4yv9rFCDR2gXbCcgd+0CgQKzqwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;