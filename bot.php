<?php

$strAccessToken = "fXyMjt64aoCzQRVOOVmvIIkq5ZM7AqanE13iuh4wyUdbjxlkz2az3h6rvum9SZBwTCY/rqjfMqhFxsms/BSn1cAa/ixWRuD6/ZYYHN0NpIsqk3puoDOjWsIf2UDT4yv9rFCDR2gXbCcgd+0CgQKzqwdB04t89/1O/w1cDnyilFU=";

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);

$strUrl = "https://api.line.me/v2/bot/message/reply";

$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
$_msg = $arrJson['events'][0]['message']['text'];


$api_key="aIiwdfg9E1pqPbVgl69-jaUVzpu91r5i";
$url = 'https://api.mlab.com/api/1/databases/2lor/collections/linebot?apiKey='.$api_key.'';
$json = file_get_contents('https://api.mlab.com/api/1/databases/2lor/collections/linebot?apiKey='.$api_key.'&q={"question":"'.$_msg.'"}');
$data = json_decode($json);
$isData=sizeof($data);

if (strpos($_msg, 'สอนไก่') !== false) {
  if (strpos($_msg, 'สอนไก่') !== false) {
    $x_tra = str_replace("สอนไก่","", $_msg);
    $pieces = explode("|", $x_tra);
    $_question=str_replace("[","",$pieces[0]);
    $_answer=str_replace("]","",$pieces[1]);
    //Post New Data
    $newData = json_encode(
      array(
        'question' => $_question,
        'answer'=> $_answer
      )
    );
    $opts = array(
      'http' => array(
          'method' => "POST",
          'header' => "Content-type: application/json",
          'content' => $newData
       )
    );
    $context = stream_context_create($opts);
    $returnValue = file_get_contents($url,false,$context);
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = 'ขอบคุณที่สอนฉัน';
  }
}else{
  if($isData >0){
   foreach($data as $rec){
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = $rec->answer;
   }
  }else{
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    // $arrPostData['messages'][0]['text'] = 'ไม่เข้าใจคุณเลย คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนไก่[คำถาม|คำตอบ]';
    $arrPostData['messages'][0]['text'] = 'ผมไม่เข้าใจคุณเลย รบกวนถามใหม่ค๊าบ';
  }
}


$channel = curl_init();
curl_setopt($channel, CURLOPT_URL,$strUrl);
curl_setopt($channel, CURLOPT_HEADER, false);
curl_setopt($channel, CURLOPT_POST, true);
curl_setopt($channel, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($channel, CURLOPT_RETURNTRANSFER,true);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($channel);
curl_close ($channel);
?>