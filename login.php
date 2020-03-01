<?php
require "db/dbconnector.php";
$method = $_SERVER["REQUEST_METHOD"];
session_start();
if ($method === "GET") :
    ?>
    <!doctype html>
    <html lang="de">
    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

    <?php include("includes/header.php"); ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="secret"><br>
                <input type="text" name="code"><br>
                <input type="submit" value="submit">
            </form>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>

<?php

elseif ($method === "POST") :

    $code = $_POST["code"];
    $secret = $_POST["secret"];
    $stmt = $pdo->prepare("select permission from users where secret=? and code =?");
    $stmt->execute([$secret, md5($code)]);
    $permission = $stmt->fetch();
    if (!empty($permission)) {
        if ($permission[0] > 0) {
            $_SESSION["isAdmin"] = true;
            header("Location: admin.php");
        } else {
            $_SESSION["isAdmin"] = false;
            header("Location: user.php");
        }
    } else {
        header("Location: login.php");
    }
endif;

?>