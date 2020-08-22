<?php
session_start();
if (!$_SESSION["isAdmin"]) :
    if ($_SESSION["isLoggedIn"]) header("Location: user.php");
    else header("Location: index.php");
else :
    require_once "db/dbController.php";
    require_once "db/dbconnector.php";
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

    <?php include("includes/header.php"); ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Getränkeverkauf <small class="text-muted">Ausgabe</small></h1>
            <form action="./controller/buy.php" method="post">
                <select name="product" id="product-select">
                    <option value="null">Bitte auswählen!</option>
                    <?php
                    foreach (dbController::getProducts($pdo) as $product) {
                        if ($product["amount"] > 0) {
                            echo '<option value="' . $product["id"] . '">' . $product["name"] . ' : ' . number_format((float)$product["price"], 2, ',', ' ') . ' €' . '</option>';
                        }
                    }
                    ?>
                </select> <br>
                <input type="number" name="amount" placeholder="Amount" min="1" /> <br>
                <input type="text" name="authSecret" placeholder="authSecret" /> <br>
                <input type="number" name="authCode" placeholder="authCode" /> <br>
                <input type="text" name="userSecret" placeholder="userSecret" /> <br>
                <input type="number" name="userCode" placeholder="userCode" min="0000" max="9999" /> <br>
                <input type="submit" value="Kaufen">
            </form>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>
<?php
endif;
?>