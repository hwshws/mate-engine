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
    <html lang="de">

    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

    <?php include("includes/header.php"); ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Getränkeverkauf <small class="text-muted">Produktinformation</small></h1>
            <table id="product-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Preis</th>
                    <th>Restliche Getränke</th>
                    <th>Flaschen pro Kasten</th>
                    <th>Ausgabeberechtigung</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <!-- TODO: I don't know css KEKW -->
                    <!-- TODO: Use a div and center align -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><img src="assets/icons/plus-circle.svg" alt="Add" class="add-btn" title="Hinzufügen"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    <script src="assets/js/product.js"></script>
    </body>

    </html>
<?php
endif;
?>