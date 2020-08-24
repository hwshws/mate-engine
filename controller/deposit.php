<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";

if (dbController::isAdmin($pdo, $_POST["authSecret"], $_POST["authCode"])) {
    if (dbController::validateUser($pdo, $_POST["userSecret"], $_POST["userCode"])) {
        dbController::addUserBalance($pdo, $_POST["userSecret"], $_POST["balance"]);
        header("Location: ../index.php");
    } else {
        header("Location: ../einzahlen.php?success=false&err=user");
    }
} else {
    header("Location: ../einzahlen.php?success=false&err=auth");
}
