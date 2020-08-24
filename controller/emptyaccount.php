<?php

require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

$authSecret = $post["authSecret"];
$authCode = $post["authCode"];
$userSecret = $post["userSecret"];
$userCode = $post["userCode"];

if (dbController::isAdmin($pdo, $authSecret, $authCode)) {
    if (dbController::validateUser($pdo, $userSecret, $userCode)) {
        dbController::emptyUserAccount($pdo, $userSecret);
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "User"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Auth"));
}
