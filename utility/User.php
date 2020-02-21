<?php


class User
{
    private $dbh;
    private $user_id;
    private $vorname;
    private $nachname;
    private $guthaben;
    private $secret;
    private $is_authorized = false;

    public function __construct($secret)
    {
        $this->dbh = $pdo;
        $this->secret = $secret;
        $this->reloadUserData();
    }

    private function reloadUserData(){
        if($this->userExists()){
            $userData = $this->fetchUserData();
            $this->user_id = $userData["ID"];
            $this->vorname = $userData["vorname"];
            $this->nachname = $userData["nachname"];
            $this->guthaben = $userData["guthaben"];
            $this->secret = $userData["secret"];
            if($userData["ausgabe-ok"] == "1"){
                $this->is_authorized = true;
            }
        }
    }

    public function userExists(){
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM users WHERE secret=:secret");
            $stmt->bindParam(":secret", $this->secret);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $exists = null;
            if (count($res) > 0) {
                $exists = true;
            } elseif (count($res) <= 0) {
                $exists = false;
            }
            return $exists;
        } catch (PDOException $e) {
            echo "Getting data from users failed: " . $e->getMessage();
        }
    }

    public function fetchUserData(){
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM users WHERE secret=:secret");
            $stmt->bindParam(":secret", $this->secret);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $userData = null;
            foreach ($res as $re) {
                foreach ($re as $key => $item) {
                    $userData[$key] = $item;
                }
            }
            return $userData;
        } catch (PDOException $e) {
            echo "Getting data from users failed: " . $e->getMessage();
        }
    }


}