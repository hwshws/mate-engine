<?php
require_once "db/dbconnector.php";
require_once "db/dbController.php";
session_start();
if (!$_SESSION["isLoggedIn"]) :
    header("Location: index.php");
else :
    ?>
    <!doctype html>
    <html lang="de">
    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM - Userbackend</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

    <?php
    include("includes/header.php");
    ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Getränkeverkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>
            <p> Dein Guthaben:
                <?php
                    echo number_format((float)dbController::getUserBalance($pdo, $_SESSION["uid"]), 2, ',', ' ') . " €";
                ?>
            </p>


        </div>
    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>

<?php
endif;
?>