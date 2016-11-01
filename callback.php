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
    $manystr = file_get_contents('report.txt'); //一堆字
    $sort_str = ajsort($manystr);
    $response = $bot->replyText($replytoken, $sort_str);
}
elseif ($get_text == '回報囉') {
    for ($i=52; $i < 70; $i++) {
        $value.="$i:\n";
    }
    $response = $bot->replyText($replytoken, $value);
}
// elseif (preg_match('/^[0-9]{0,2}\s.*/', $get_text, $matches)) {  //頭匹配符ex:兩個數字開頭加上一個空白
//     file_put_contents('report.txt', $get_text, FILE_APPEND);
//     file_put_contents('report.txt', "\n", FILE_APPEND);
// }
function ajsort($str)
{
    $textarr = explode("\n", $str);
    foreach ($textarr as $key => $value) {
        $newarr[] = explode(' ', $value);
        $num = array();
        foreach ($newarr as $key => $row) {
            $num[$key] = $row[0];
        }
    }
    array_multisort($num, SORT_ASC, $newarr);
    foreach ($newarr as $key => $row) {
        $output .= "$row[0]:$row[1]\n";
    }

    return $output;
}
