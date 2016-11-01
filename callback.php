<?php
$jsonstring = file_get_contents('php://input');
$jsonobject = json_decode($jsonstring);
file_put_contents("debug.txt", $jsonstring,FILE_APPEND);
require './vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('8WMjhheTQjsHniTtkyaZTDZi7+ntxMbY7rClcesJrjEhoSjwJsW50KlkPmjiR/SuE4vrkQZgiN/aix518Xk+Pfkn9ZBj6UdrUanpBi+99le6vNd65efQY731EJYFqe77lZud8NguNJcHgYFf7JCfvQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'ee39d46841657ce270c34c1f9a084c48']);
$replytoken=$jsonobject->events[0]->replyToken;
$get_text=$jsonobject->events[0]->message->text;

switch ($get_text) {
    case '班頭清查人數開始':
        $response_text="向前一步走！向左轉";
        break;

    default:
        $response_text=$get_text;
        break;
}
$response = $bot->replyText($replytoken, $response_text);
