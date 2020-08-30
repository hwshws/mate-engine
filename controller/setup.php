<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);

if (!dbController::isSetup($pdo)) {
    dbController::setup($pdo, $post["balance"], $post["authSecret"], $post["authCode"]);
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "An error occurred"));
}