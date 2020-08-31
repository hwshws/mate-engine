<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => array("title" => "Getränk konnte nicht gekauft werden!"));

if (!(
    checkPost($post, "userSecret", "userCode", "authSecret", "authCode", "product", "amount") &&
    is_numeric($post["product"]) && ((int)$post["product"]) > 0 &&
    is_numeric($post["amount"]) && ((int)$post["amount"]) > 0
)) {
    $resp["data"] = badRequest();
} else {
    if (dbController::isAdmin($pdo, $post['authSecret'], $post['authCode'])) {
        if (dbController::validateUser($pdo, $post['userSecret'], $post['userCode'])) {
            $resp = dbController::transaction($pdo, $post['product'], $post['amount'], $post['userSecret'], $post['authSecret']);
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