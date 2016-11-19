<?php

$jsonstring = file_get_contents('php://input');
$jsonobject = json_decode($jsonstring);
// file_put_contents('debug.txt', $jsonstring, FILE_APPEND);
require './vendor/autoload.php';
$token = getenv('token');
$channelSecret = getenv('channelSecret');
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient("$token");
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => "$channelSecret"]);
$replytoken = $jsonobject->events[0]->replyToken;
$get_text = $jsonobject->events[0]->message->text;

$order = array();
for ($i = 52; $i <= 69; ++$i) {
    $order[$i] = '';
}

if ($get_text == '機器人回報') {
    $manystr = file_get_contents('report.txt'); //一堆字
    $textarr = explode("\n", $manystr);
    foreach ($textarr as $key => $value) {
        $newarr[] = explode(PHP_EOL, $value);
    }
    foreach ($newarr as $key => $value) {
        $num = $value[0];
        $do = $value[1];
        $order[$num] = $do;
    }
    foreach ($order as $key => $value) {
        $output .= "$key:$value\n";
    }
    $output .= '報告完畢';
    $response = $bot->replyText($replytoken, $output);
} elseif ($get_text == '回報囉') {
    foreach ($order as $key => $value) {
        $output .= "$key:$value\n";
    }
    $output .= '報告完畢';
    $response = $bot->replyText($replytoken, $output);
} elseif ($get_text == '機器人清除') {
    file_put_contents('report.txt', '');
    $response = $bot->replyText($replytoken, '紀錄已經清除，請班長指示爾後之行動。');
} elseif (preg_match('/^[0-9]{0,2}\s.*/', $get_text, $matches)) {  //頭匹配符ex:兩個數字開頭加上一個空白
    file_put_contents('report.txt', $get_text . PHP_EOL, FILE_APPEND);
}
