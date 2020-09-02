<?php

require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => array("title" => "Konto konnte nicht geleert werden!"));

$authSecret = $post["authSecret"];
$authCode = $post["authCode"];
$userSecret = $post["userSecret"];
$userCode = $post["userCode"];

if (dbController::isAdmin($pdo, $authSecret, $authCode)) {
    if (dbController::validateUser($pdo, $userSecret, $userCode)) {
        dbController::emptyUserAccount($pdo, $userSecret);
        $resp["success"] = true;
    } else {
        http_response_code(401);
        $resp["data"]["text"] = "Benutzerauthentifizierung fehlgeschlagen!";
    }
} else {
    http_response_code(401);
    $resp["data"]["text"] = "Adminauthentifizierung fehlgeschlagen!";
}
echo json_encode($resp);