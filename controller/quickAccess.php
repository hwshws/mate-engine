<?php
require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

try {
    echo json_encode(array("success" => true, "balance" => dbController::getUserBalanceBySecret($pdo, $post["secret"])));
} catch (PDOException $e) {
    echo json_encode(array("success" => false, "message" => $e));
}