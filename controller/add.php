<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";

print_r($_POST);
if ($_POST['authCodeDoubleCheck'] == $_POST['authCode']) {
    dbController::createUser($pdo, $_POST['userSecret'], $_POST['userCode'], $_POST['initialAmont'], $_POST["permission"]);
    echo "Dinge";
    header("Location: ../adduser.php?success=true");
} else {
    echo "authCode mismatch";
    header("Location: ../adduser.php?success=false&err=authcode");
}
