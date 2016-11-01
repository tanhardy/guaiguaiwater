<?php

$jsonstring = file_get_contents('php://input');
$jsonobject = json_decode($jsonstring);
file_put_contents('debug.txt', $jsonstring, FILE_APPEND);
require './vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('8WMjhheTQjsHniTtkyaZTDZi7+ntxMbY7rClcesJrjEhoSjwJsW50KlkPmjiR/SuE4vrkQZgiN/aix518Xk+Pfkn9ZBj6UdrUanpBi+99le6vNd65efQY731EJYFqe77lZud8NguNJcHgYFf7JCfvQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'ee39d46841657ce270c34c1f9a084c48']);
$replytoken = $jsonobject->events[0]->replyToken;
$get_text = $jsonobject->events[0]->message->text;

if ($get_text == '機器人回報!') {
    $str = file_get_contents('report.txt');//一堆字
    $textarr=explode('\n',$str);//切割每一筆留言
    foreach ($textarr as $key => $value) {
        file_put_contents('debug.txt', $value, FILE_APPEND);
    }
    // $response = $bot->replyText($replytoken, $textarr);
    // file_put_contents('report.txt', '');
} elseif (preg_match('/^[0-9]{0,2}\s.*/', $get_text,$matches)) {  //頭匹配符ex:兩個數字開頭加上一個空白
    file_put_contents('report.txt', $get_text, FILE_APPEND);
    file_put_contents('report.txt', "\n", FILE_APPEND);
}
