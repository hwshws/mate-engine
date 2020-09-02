<?php
require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => null);

if (checkPost($post, "secret")) {
    try {
        $balance = dbController::getUserBalanceBySecret($pdo, $post["secret"]);
        if ($balance) {
            $resp["success"] = true;
            $resp["data"]["balance"] = $balance;
        } else {
            $resp["data"]["text"] = "Nutzer wurde nicht gefunden!";
        }
    } catch (PDOException $e) {
        $resp["data"]["text"] = $e;
    }
} else {
    $resp["data"] = badRequest();
}
echo json_encode($resp);