<?php
require_once "../db/dbController.php";
require_once "../db/dbconnector.php";

print_r($_POST);
if ($_POST['authCodeDoubleCheck'] == $_POST['authCode']) {

}
else {
    echo  "authCode mismatch";
}

if (dbController::createUser($pdo, $_POST['userSecret'], $_POST['userCode'], $_POST['initialAmont']))
{
    if (dbController::validateUser($pdo, $_POST['authSecret'], $_POST['authCode'])) {
        if (dbController::transaction($pdo, $_POST['product'], (int)$_POST['amount'], $_POST['userSecret'], $_POST['authSecret'])) {
            header("Location: ../home");
        } else {
            echo "Something went horribly wrong";
        }
    } else {
        echo "Auth not verified";
    }
} else {
    echo "User not verified";
}