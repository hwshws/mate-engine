<?php
require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

if (checkPost($post, "secret")) {
    try {
        $balance = dbController::getUserBalanceBySecret($pdo, $post["secret"]);
        if ($balance) {
            echo json_encode(array("success" => true, "balance" => $balance));
        } else {
            echo json_encode(array("success" => false, "message" => "User not found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("success" => false, "message" => $e));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Wrong parameter(s)"));
}