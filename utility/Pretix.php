<?php

require 'config.php';

class Pretix
{

    private static $baseURI = "pretix.eu/api/v1/organizers/" . pretixOrga . "/events/" . pretixEvent;

    public static function fetchPretixUsers()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Pretix::$baseURI . "/orders/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Token " . pretixToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}