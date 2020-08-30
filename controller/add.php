<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

if (!(
    checkPost($post, "authSecret", "authCode", "userSecret", "userCode", "balance", "permission", "userCodeDoubleCheck") &&
    ((float)$post["balance"]) >= 0 && ((float)$post["balance"]) < 100 &&
    ((int)$post["permission"]) >= 0 && ((int)$post["permission"]) <= 3
)) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Wrong parameter(s)"));
} else {
    if (dbController::isAdmin($pdo, $post["authSecret"], $post["authCode"])) {
        if ($post['userCodeDoubleCheck'] == $post['userCode']) {
            try {
                dbController::createUser($pdo, $post['userSecret'], $post['userCode'], $post['balance'], $post["permission"]);
                echo json_encode(array("success" => true));
            } catch (PDOException $e) {
                http_response_code(400);
                echo json_encode(array("success" => false, "message" => "User already exists"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "User code mismatch"));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("success" => false, "message" => "Admin auth failed"));
    }
}