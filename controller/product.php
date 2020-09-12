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
        if (checkPost($post, "pid")) {
            try {
                dbController::deleteProduct($pdo, $post["pid"]);
                $resp["success"] = true;
                $resp["data"]["title"] = "Produkt wurde gelöscht!";
            } catch (PDOException $e) {
                // TODO: Error handling
                $resp["data"]["title"] = "Produkt konnte nicht gelöscht werden!";
                $resp["data"]["text"] = $e;
            }
        } else {
            $resp["data"] = badRequest();
        }
    } else if ($method === "POST") {
        $resp["data"]["title"] = "Produkt konnte nicht hinzugefügt werden!";
        if (checkPost($post, "id", "name", "price", "crates", "bottles", "bpc", "permission")) {
            try {
                $resp = dbController::addProduct($pdo, $post["name"], $post["price"], $post["crates"] + $post["bottles"] / $post["bpc"], $post["bpc"], $post["permission"]);
            } catch (PDOException $e) {
                $resp["data"]["text"] = $e;
            }
        } else {
            $resp["data"] = badRequest();
        }
    } else if ($method === "PUT") {
        $resp["data"]["title"] = "Produkt konnte nicht geupdated werden!";
        if (checkPost($post, "id", "name", "price", "crates", "bottles", "bpc", "permission")) {
            try {
                $resp = dbController::updateProduct($pdo, $post["id"], $post["price"], $post["name"], $post["crates"] + $post["bottles"] / $post["bpc"], $post["bpc"], $post["permission"]);
            } catch (PDOException $e) {
                $resp["data"]["text"] = $e;
            }
        } else {
            $resp["data"] = badRequest();
        }
    } else if ($method === "GET") {
        // TODO: Get products might be used for js refresh
    } else {
        http_response_code(405);
        $resp["data"]["title"] = "Method not allowed!";
    }
} else {
    http_response_code(401);
    $resp["data"]["title"] = "Adminberechtigungen benötigt!";
}
echo json_encode($resp);