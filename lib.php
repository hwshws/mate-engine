<?php
require_once "config.php";

define("curlOPTS", array(
    CURLOPT_URL => zulipURL . "/api/v1/messages",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_USERPWD => zulipBotEmail . ':' . zulipBotSecret
));

function sendZulipMessage(string $message)
{
    $curl = curl_init();
    curl_setopt_array($curl, curlOPTS);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        "type" => "stream",
        "to" => zulipChannel,
        "topic" => zulipTopic,
        "content" => $message,
    ));
    $result = curl_exec($curl);
    if (curl_errno($curl) > 0) die(curl_error($curl));
    curl_close($curl);
    return $result;
}

function checkPost($post, ...$params)
{
    foreach ($params as $param) {
        if (!array_key_exists($param, $post))
            return $param;
    }
    return true;
}