<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

if (!(
    checkPost($post, "userSecret", "userCode", "authSecret", "authCode", "product", "amount") &&
    is_numeric($post["product"]) && ((int)$post["product"]) > 0 &&
    is_numeric($post["amount"]) && ((int)$post["amount"]) > 0
)) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Wrong parameter(s)"));
} else {
    if (dbController::isAdmin($pdo, $post['authSecret'], $post['authCode'])) {
        if (dbController::validateUser($pdo, $post['userSecret'], $post['userCode'])) {
            echo json_encode(dbController::transaction($pdo, $post['product'], $post['amount'], $post['userSecret'], $post['authSecret']));
        } else {
            http_response_code(401);
            echo json_encode(array("success" => false, "message" => "User auth failed"));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("success" => false, "message" => "Admin auth failed"));
    }
}