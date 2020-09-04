<?php
session_start();
require_once "../db/dbconnector.php";
require_once "../db/dbController.php";
require_once "../lib.php";
header('Content-Type: application/json');

$method = $_SERVER["REQUEST_METHOD"];
$post = json_decode(file_get_contents('php://input'), true);
$resp = array("success" => false, "data" => null);

if ($_SESSION["isLoggedIn"] && $_SESSION["isAdmin"]) {
    if ($method === "DELETE") {
        $resp["data"]["title"] = "Produkt konnte nicht gelöscht werden";
        if (checkPost($post, "pid")) {
            try {
                dbController::deleteProduct($pdo, $post["pid"]);
                $resp["success"] = true;
                $resp["data"]["title"] = "Produkt wurde gelöscht";
            } catch (PDOException $e) {
                // TODO: Error handling
                $resp["data"]["text"] = $e;
            }
        } else {
            $resp["data"] = badRequest();
        }
    } else if ($method === "POST") {
        // TODO: Add product
    } else if ($method === "PUT") {
        // TODO: Update product
    } else {
        http_response_code(405);
        $resp["data"]["title"] = "Method not allowed!";
    }
} else {
    http_response_code(401);
    $resp["data"]["title"] = "Adminberechtigungen benötigt!";
}
echo json_encode($resp);