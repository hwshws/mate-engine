<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => null);

if (!checkPost($post, "balance", "authSecret", "authCode")) $resp["data"] = badRequest();
else {
    if (!dbController::isSetup($pdo)) {
        dbController::setup($pdo, $post["balance"], $post["authSecret"], $post["authCode"]);
        $resp["success"] = true;
        $resp["data"]["title"] = "Setup abgeschlossen!";
    } else {
        $resp["data"] = array(
            "title" => "Setup unterbrochen!",
            "text" => "Setup wurde bereits durchgeführt!",
        );
    }
}
echo json_encode($resp);