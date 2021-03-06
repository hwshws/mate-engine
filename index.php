<?php
session_start();
require_once "db/dbconnector.php";
require_once "db/dbController.php";
if ($_SESSION["isLoggedIn"]) :
    if ($_SESSION["isAdmin"]) header("Location: admin.php");
    else header("Location: user.php");
elseif (!dbController::isSetup($pdo)) :
    header("Location: setup.php");
else :
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
            <div class="d-flex justify-content-center center-block">
                <form method="post" action="controller/login.php" data-success="loginSuccess" class="default-form">
                    <h1>Login</h1> <br>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <label for="secret" class="input-group-text">QR-Code</label>
                        </div>
                        <input type="text" class="form-control" name="secret"
                               id="secret" required/>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <label for="code" class="input-group-text">Passwort</label>
                        </div>
                        <input name="code" type="password" id="code" class="form-control" required/>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <input type="submit" value="Login" class="btn btn-dark" style="width: 100%">
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>
<?php
endif;
?>