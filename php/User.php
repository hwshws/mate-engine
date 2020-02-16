<?php


class User
{
    private $dbh;
    private $user_id;
    private $username;
    private $guthaben;
    private $secret;
    private $is_authorized;

    public function __construct($secret)
    {
        $dbh = Config::dbCon();
    }

    private function fetchUserData(){

    }
}