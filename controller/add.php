<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";
require_once "../lib.php";
header('Content-Type: application/json');

$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => array("title" => "Nutzer konnte nicht angelegt werden!"));

if (!(
    checkPost($post, "authSecret", "authCode", "userSecret", "userCode", "balance", "permission", "userCodeDoubleCheck") &&
    ((float)$post["balance"]) >= 0 && ((float)$post["balance"]) < 100 &&
    ((int)$post["permission"]) >= 0 && ((int)$post["permission"]) <= 3
)) {
    $resp["data"] = badRequest();
} else {
    if (dbController::isAdmin($pdo, $post["authSecret"], $post["authCode"])) {
        if ($post['userCodeDoubleCheck'] == $post['userCode']) {
            try {
                dbController::createUser($pdo, $post['userSecret'], $post['userCode'], $post['balance'], $post["permission"]);
                $resp["success"] = true;
                $resp["data"]["title"] = "Neuen Nutzer erfolgreich angelegt!";
            } catch (PDOException $e) {
                http_response_code(400);
                $resp["data"]["text"] = "Benutzer existiert bereits!";
            }
        } else {
            http_response_code(400);
            $resp["data"]["text"] = "Benutzerpins stimmen nicht überein!";
        }
    } else {
        http_response_code(401);
        $resp["data"]["text"] = "Adminauthentifizierung fehlgeschlagen!";
    }
}
echo json_encode($resp);