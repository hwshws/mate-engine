<?php
session_start();
require "../db/dbController.php";
require "../db/dbconnector.php";

// TODO: Check `code` type
$res = dbController::login($pdo, $_POST["secret"], $_POST["code"]);

if ($res["success"]) {
    $_SESSION["isLoggedIn"] = true;
    $_SESSION["uid"] = $res["user"]["id"];
    if ($res["user"]["permission"] > 0) {
        $_SESSION["isAdmin"] = true;
        header("Location: ../admin.php");
    } else {
        $_SESSION["isAdmin"] = false;
        header("Location: ../user.php");
    }
} else {
    header("Location: ../home?err=login");
}

// Consider: JSON vs. Redirects