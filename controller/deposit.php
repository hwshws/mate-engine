<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

if (!(
    checkPost($post, "authSecret", "authCode", "userSecret", "userCode", "balance") &&
    is_numeric($post["userCode"]) && is_numeric($post["authCode"]) && is_numeric($post["balance"]) &&
    $post["balance"] > 0 && $post["balance"] < 100
)) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Wrong parameter(s)"));
} else {
    if (dbController::isAdmin($pdo, $post["authSecret"], $post["authCode"])) {
        if (dbController::validateUser($pdo, $post["userSecret"], $post["userCode"])) {
            dbController::addUserBalance($pdo, $post["userSecret"], $post["balance"]);
            echo json_encode(array("success" => true));
        } else {
            http_response_code(401);
            echo json_encode(array("success" => false, "message" => "User auth failed"));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("success" => false, "message" => "Admin auth failed"));
    }
}