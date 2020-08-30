<?php
session_start();
require "../db/dbController.php";
require "../db/dbconnector.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
if (!(array_key_exists("secret", $post) && array_key_exists("code", $post))) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Wrong parameter"));
} else {
    $res = dbController::login($pdo, $post["secret"], $post["code"]);

    if ($res["success"]) {
        $_SESSION["isLoggedIn"] = true;
        $_SESSION["uid"] = $res["user"]["id"];
        if ($res["user"]["permission"] > 0) {
            $_SESSION["isAdmin"] = true;
        } else {
            $_SESSION["isAdmin"] = false;
        }
        echo json_encode(array("success" => true));
    } else {
        http_response_code(401);
        echo json_encode(array("success" => false, "message" => "Bad credentials"));
    }
}