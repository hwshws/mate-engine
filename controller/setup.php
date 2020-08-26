<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";

if (!dbController::isSetup($pdo)) {
    dbController::setup($pdo, $_POST["balance"], $_POST["authSecret"], $_POST["authCode"]);
    header("Location: ../index.php");
} else {
    header("Location: ../index.php");
}