<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";

if (dbController::isAdmin($pdo, $_POST["authSecret"], $_POST["authCode"])) {
    if ($_POST['userCodeDoubleCheck'] == $_POST['userCode']) {
        dbController::createUser($pdo, $_POST['userSecret'], $_POST['userCode'], $_POST['amount'], $_POST["permission"]);
        echo "Dinge";
        header("Location: ../adduser.php?success=true");
    } else {
        echo "authCode mismatch";
        header("Location: ../adduser.php?success=false&err=authcode");
    }
} else {
    header("Location: ../adduser.php?success=false&err=auth");
}