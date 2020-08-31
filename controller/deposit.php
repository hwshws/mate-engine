<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => array("title" => "Guthaben konnte nicht gutgeschrieben werden!"));

if (!(
    checkPost($post, "authSecret", "authCode", "userSecret", "userCode", "balance") &&
    is_numeric($post["userCode"]) && is_numeric($post["authCode"]) && is_numeric($post["balance"]) &&
    $post["balance"] > 0 && $post["balance"] < 100
)) {
    $resp["data"] = badRequest();
} else {
    if (dbController::isAdmin($pdo, $post["authSecret"], $post["authCode"])) {
        if (dbController::validateUser($pdo, $post["userSecret"], $post["userCode"])) {
            dbController::addUserBalance($pdo, $post["userSecret"], $post["balance"]);
            $resp["success"] = true;
            $resp["data"]["title"] = "Guthaben gutgeschrieben!";
        } else {
            http_response_code(401);
            $resp["data"]["text"] = "Benutzerauthentifizierung fehlgeschlagen!";
        }
    } else {
        http_response_code(401);
        $resp["data"]["text"] = "Adminauthentifizierung fehlgeschlagen!";
    }
}
echo json_encode($resp);